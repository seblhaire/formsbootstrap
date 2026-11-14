import $ from 'jquery';
import './jquery.richtext.js';
var SebFormHelper = {
    form: null,
    divalert: null,
    buttonsdiv: null,
    options: null,
    savedData: null,
    init: function (form, options) {
        this.form = $(form);
        this.options = options;
        this.clearonclick();
        if (this.options.buildresultalert) {
            this.insertAlert();
        }
        if (this.options.buildbuttons && this.form.children('input[type=submit]').length == 0) {
            this.insertButtons();
        }
        this.form.on('submit', {self: this}, this.submit);
        this.save();
        if (this.options.checkonleave) {
            $(window).bind('beforeunload', {self: this}, this.pageleave);
        }
    },
    save: function () {
        this.savedData = this.getData(true);
    },
    isModified: function () {
        return this.savedData != this.getData(true);
    },
    pageleave: function (event) {
        //event.preventDefault();
        var self = event.data.self;
        if (self.isModified()) {
            return true;
        } else {
            event = null; // i.e; if form state change show warning box, else don't show it.
        }
    },
    fillwithdata: function (res) {
        $('input[type=checkbox]').each(function () {
            $(this).prop('checked', false)
        });
        $('input[type=radio]').each(function () {
            $(this).prop('checked', false)
        });
        $('option').each(function () {
            $(this).prop('selected', false)
        });
        $.each(res, function (key, value) {
            if ($('#' + key).data('sebrichtexthelper') != undefined) {
                //console.log('rth ' + key);
                $('#' + key).data('sebrichtexthelper').loadContent(value);
            } else if ($('#' + key).data('uploader') != undefined) {
                //console.log('upl ' + key);
                $('#' + key).data('uploader').reset();
                if (Array.isArray(value)) {
                    var ar = value;
                } else {
                    var ar = [value];
                }
                result = {
                    ok: true,
                    infos: {baseurl: ''},
                    files: ar
                };
                $('#' + key).data('uploader').getresultprocessor().process(result);
            } else if ($('#' + key).data('tagsinput') != undefined) {
                $('#' + key).data('tagsinput').reset();
                $('#' + key).data('tagsinput').addtolist(value);
            } else if ($('#' + key).data('sebdaterangepicker') != undefined) {
                //console.log('date ' + key);
                if (Array.isArray(value)) {
                    $('#' + key).data('sebdaterangepicker').setDoubleCalendar(moment(value[0]), moment(value[1]));
                } else {
                    $('#' + key).data('sebdaterangepicker').setSingleCalendar(moment(value));
                }
            } else if (
                    $('#' + key).length > 0 && (
                    $('#' + key)[0].tagName == 'TEXTAREA' ||
                    (
                            $('#' + key)[0].tagName == 'INPUT' &&
                            (
                                    $('#' + key)[0].type == 'text' ||
                                    $('#' + key)[0].type == 'hidden' ||
                                    $('#' + key)[0].type == 'number' ||
                                    $('#' + key)[0].type == 'color' ||
                                    $('#' + key)[0].type == 'range' ||
                                    $('#' + key)[0].type == 'email'
                                    )
                            )
                    )
                    ) {
                //console.log('in ' + key);
                $('#' + key).val(value).trigger('input');
            } else if (
                    $('#' + key).length > 0 &&
                    $('#' + key)[0].tagName == 'SELECT'
                    ) {
                if (!Array.isArray(value)) {
                    value = [value];
                }
                for (i in value) {
                    $('#' + key + ' option[value=' + value[i].toString() + ']').prop('selected', true)
                }
            } else if ($('input[type=checkbox][name=' + $.escapeSelector(key + '[]') + ']').length > 0) {
                for (i in value) {
                    $('input[type=checkbox][name=' + $.escapeSelector(key + '[]') + '][value=' + value[i].toString() + ']').prop('checked', true);
                }
            } else if ($('input[type=radio][name=' + $.escapeSelector(key) + ']').length > 0) {
                $('input[type=radio][name=' + $.escapeSelector(key) + '][value=' + value + ']').prop('checked', true);
            }
        });
        if (this.options.filldatacallback != null) {
            this.options.filldatacallback(res);
        }
        this.save();
    },
    getResultErrorMessage: function (res) {
        if (this.options.evalajaxres_resultmessage != null) {
            return this.options.evalajaxres_resultmessage(res);
        } else {
            return res.message;
        }
    },
    checkformresult: function (res) {
        if (this.options.evalajaxres_callback != null) {
            return this.options.evalajaxres_callback(res);
        } else {
            return res.ok;
        }
    },
    submit: function (event) {
        event.preventDefault();
        var self = event.data.self;
        self.save();
        if (self.options.validate) {
            self.removevalidation();
            if (!self.validate()) {
                return false;
            }
        }
        if (self.options.ajaxcallback != null) {
            $('#' + self.form.attr('id') + '_submit_spinner').show();
            $.ajax({
                url: self.form.prop('action'),
                encoding: 'utf8',
                data: self.getData(),
                type: 'post',
                dataType: 'json',
                headers: {
                    'X-CSRF-Token': self.options.csrf
                },
                cache: false
            })
                    .done(function (res) {
                        $('#' + self.form.attr('id') + '_submit_spinner').hide();
                        if (self.checkformresult(res)) {
                            var message = self.options.ajaxcallback(res);
                            if (message == undefined || message == null || message.length == undefined || message.length == 0) {
                                message = self.options.resultok;
                            }
                            self.successmessage(message);
                        } else {
                            var message = self.getResultErrorMessage(res);
                            if (message == undefined || message == null || message.length == undefined || message.length == 0) {
                                message = self.options.resultfalse;
                            }
                            self.errormessage(message);
                        }
                    })
                    .fail(function (jqXHR, textStatus, errorThrown) {
                        $('#' + self.form.attr('id') + '_submit_spinner').hide();
                        if (jqXHR.status == 419) {
                            self.errormessage(self.options.tokenexpired);
                        } else if (jqXHR.status == 403){
                            self.errormessage(self.options.nonauthorized);
                        } else if (jqXHR.status == 422){
                            var response = $.parseJSON(jqXHR.responseText);
                            self.errormessage(response.message);
                        } else {
                            self.errormessage(self.options.resultfalse);
                        }
                    });
        }
    },
    getData: function (serialize) {
        if (this.options.data_build_function != null) {
            data = this.options.data_build_function();
            if (serialize) {
                var str = '';
                $(data).each(function (i, elt) {
                    str += (str.length > 0 ? '&' : '') + elt.name + '=' + encodeURIComponent(elt.value);
                });
                return str;
            } else {
                return data;
            }
        } else {
            if (serialize) {
                return this.form.serialize();
            } else {
                return this.form.serializeArray();
            }
        }
    },
    removevalidation: function () {
        $("#" + this.form.attr('id') + " ." + this.options.requiredclass).each(function (i) {
            $(this).removeClass('is-invalid').removeClass('is-valid');
        });
        $("#" + this.form.attr('id') + " ." + this.options.requiredcheckclass).each(function (i) {
            $(this).removeClass('is-invalid').removeClass('is-valid');
        });
        $("#" + this.form.attr('id') + " ." + this.options.verifymailclass).each(function (i) {
            $(this).removeClass('is-invalid').removeClass('is-valid');
        });
        $("#" + this.form.attr('id') + " ." + this.options.verifypassclass).each(function (i) {
            $(this).removeClass('is-invalid').removeClass('is-valid');
        });
        $("#" + this.form.attr('id') + " ." + this.options.verifypassmatchclass).each(function (i) {
            $(this).removeClass('is-invalid').removeClass('is-valid');
        });
        $("#" + this.form.attr('id') + " ." + this.options.verifypassold).each(function (i) {
            $(this).removeClass('is-invalid').removeClass('is-valid');
        });
        $("#" + this.form.attr('id') + " ." + this.options.requiredspecialclass).each(function (i) {
            $(this).find('.is-invalid').removeClass('is-invalid').removeClass('is-valid');
        });
        if (this.options.remove_validation_function != null) {
            this.options.remove_validation_function();
        }
    },
    clearonclick: function () {
        $("#" + this.form.attr('id') + " ." + this.options.requiredclass).each(function (i) {
            $(this).on("click", function () {
                $(this).removeClass('is-invalid').removeClass('is-valid');
            });
        });
        $("#" + this.form.attr('id') + " ." + this.options.requiredcheckclass).each(function (i) {
            $(this).on("click", function () {
                $(this).removeClass('is-invalid').removeClass('is-valid');
            });
        });
        $("#" + this.form.attr('id') + " ." + this.options.verifymailclass).each(function (i) {
            $(this).on("click", function () {
                $(this).removeClass('is-invalid').removeClass('is-valid');
            });
        });
        $("#" + this.form.attr('id') + " ." + this.options.verifypassclass).each(function (i) {
            $(this).on("click", function () {
                $(this).removeClass('is-invalid').removeClass('is-valid');
            });
        });
        $("#" + this.form.attr('id') + " ." + this.options.verifypassmatchclass).each(function (i) {
            $(this).on("click", function () {
                $(this).removeClass('is-invalid').removeClass('is-valid');
            });
        });
        $("#" + this.form.attr('id') + " ." + this.options.verifypassold).each(function (i) {
            $(this).on("click", function () {
                $(this).removeClass('is-invalid').removeClass('is-valid');
            });
        });
        $("#" + this.form.attr('id') + " ." + this.options.requiredspecialclass).each(function (i) {
            $(this).on("click", function () {
                $(this).find('.is-invalid').removeClass('is-invalid').removeClass('is-valid');
            });
        });
        if (this.options.clearonclick_function != null) {
            this.options.clearonclick_function();
        }
    },
    validate: function () {
        var self = this;
        var isValid = true;
        $("#" + self.form.attr('id') + " ." + self.options.requiredclass).each(function (i) {
            if ($(this).val() == '') {
                isValid = false;
                $(this).addClass('is-invalid');
            } else {
                $(this).addClass('is-valid');
            }
        });
        $("#" + self.form.attr('id') + " ." + self.options.selcheckclass).each(function (i) {
            var checked = false;
            $(this).find('input').each(function (j) {
                if ($(this).prop('checked')) {
                    checked = true;
                }
            });
            if (checked) {
                $(this).find('.' + self.options.requiredcheckclass).first().addClass('is-valid');
            } else {
                isValid = false;
                $(this).find('.' + self.options.requiredcheckclass).first().addClass('is-invalid');
            }
        });
        $("#" + self.form.attr('id') + " ." + self.options.verifymailclass).each(function (i) {
            if (!$(this).data('sebemailhelper').check()) {
                isValid = false;
                $(this).addClass('is-invalid');
            } else {
                $(this).addClass('is-valid');
            }
        });
        $("#" + self.form.attr('id') + " ." + self.options.verifypassclass).each(function (i) {
            if (!$(this).data('sebpasswordhelper').checkStrength()) {
                isValid = false;
                $(this).addClass('is-invalid');
            } else {
                $(this).addClass('is-valid');
            }
        });
        $("#" + self.form.attr('id') + " ." + self.options.verifypassmatchclass).each(function (i) {
            if (!$($(this).data('maininput')).data('sebpasswordhelper').checkIdentity()) {
                isValid = false;
                $(this).addClass('is-invalid');
            } else {
                $(this).addClass('is-valid');
            }
        });
        $("#" + self.form.attr('id') + " ." + self.options.verifypassold).each(function (i) {
            if (!$($(this).data('maininput')).data('sebpasswordhelper').checkOldPass()) {
                isValid = false;
                $(this).addClass('is-invalid');
            } else {
                $(this).addClass('is-valid');
            }
        });
        $("#" + self.form.attr('id') + " ." + self.options.requiredspecialclass).each(function (i) {
            if ($(this).data('sebrichtexthelper') != undefined) {
                if ($(this).data('sebrichtexthelper').isEmpty()) {
                    isValid = false;
                    $(this).find('.richText').addClass('is-invalid');
                } else {
                    $(this).find('.richText').addClass('is-valid');
                }
            }
            if ($(this).data('uploader') != undefined) {
                if ($(this).data('uploader').getresultprocessor().countFiles() == 0) {
                    isValid = false;
                    $(this).find('.uploader').addClass('is-invalid');
                } else {
                    $(this).find('.uploader').addClass('is-valid');
                }
            }
            if ($(this).data('tagsinput') != undefined) {
                if ($(this).data('tagsinput').count() == 0) {
                    isValid = false;
                    $(this).data('tagsinput').autocompleter.addClass('is-invalid');
                } else {
                    $(this).data('tagsinput').autocompleter.addClass('is-valid');
                }
            }
        });
        if (self.options.validate_function != null) {
            isValid = self.options.validate_function();
        }
        return isValid;
    },
    reset: function () {
        if (this.options.check_modified_on_reset) {
            if (this.isModified()) {
                if (confirm(this.options.modified_on_reset_confirm_text)) {
                    this._reset();
                }
            } else {
                this._reset();
            }
        } else {
            this._reset();
        }
    },
    _reset: function () {
        for (var obj of this.options.resetvalues) {
            $('#' + obj.key).val(obj.value);
        }
        $('select option').each(function (e) {
            $(this).prop('selected', false)
        });
        $('input[type=radio]').each(function (e) {
            $(this).prop('checked', false)
        });
        $('input[type=checkbox]').each(function (e) {
            $(this).prop('checked', false)
        });
        $("#" + this.form.attr('id') + " ." + this.options.resettextclass).each(function (i) {
            $(this).val('').trigger('input');
        });
        $("#" + this.form.attr('id') + " ." + this.options.resetselectclass).each(function (i) {
            $(this).find('option').each(function (j) {
                if ($(this).attr('defaultchecked') == 'defaultchecked') {
                    $(this).prop('selected', true);
                }
            });
        });
        $("#" + this.form.attr('id') + " ." + this.options.resetradioclass).each(function (i) {
            $(this).find('input').each(function (j) {
                if ($(this).attr('defaultchecked') == 'defaultchecked') {
                    $(this).prop('checked', true);
                }
            });
        });
        $("#" + this.form.attr('id') + " ." + this.options.resetcheckclass).each(function (i) {
            $(this).find('input').each(function (j) {
                if ($(this).attr('defaultchecked') == 'defaultchecked') {
                    $(this).prop('checked', true);
                }
            });
        });
        $("#" + this.form.attr('id') + " ." + this.options.resetspecialclass).each(function (i) {
            if ($(this).data('sebrichtexthelper') != undefined) {
                $(this).data('sebrichtexthelper').loadContent('');
            }
            if ($(this).data('uploader') != undefined) {
                $(this).data('uploader').reset();
            }
            if ($(this).data('tagsinput') != undefined) {
                $(this).data('tagsinput').reset();
            }
            if ($(this).data('sebdaterangepicker') != undefined) {
                $(this).data('sebdaterangepicker').reset();
            }
        });
        if (this.options.clear_function != null) {
            isValid = this.options.clear_function();
        }
        this.save();
    },
    insertButtons: function () {
        this.buttonsdiv = $('<div></div>')
                .attr('id', this.form.attr('id') + '_buttons')
                .addClass(this.options.buttondivclass)
        var text = $('<span></span>')
                .attr('id', this.form.attr('id') + '_submit_text').html(this.options.submitbtnlbl);
        var spinner = $('<i></i>')
                .attr('id', this.form.attr('id') + '_submit_spinner')
                .addClass("fa-solid fa-spinner fa-spin-pulse")
                .hide();
        $('<button></button>')
                .attr('id', this.form.attr('id') + '_submit')
                .attr('type', 'submit')
                .addClass(this.options.submitbtnclass)
                .append(text)
                .append(spinner)
                .on('click', {self: this}, function (e) {
                    e.data.self.submit(e);
                })
                .appendTo(this.buttonsdiv);
        if (this.options.additionalbuttons.length > 0) {
            for (var i in this.options.additionalbuttons) {
                var btn = $('<button></button>')
                        .attr('type', 'button');
                $.map(this.options.additionalbuttons[i], function (value, key) {
                    if (key != 'value') {
                        btn.attr(key, value);
                    }
                });
                btn.html(this.options.additionalbuttons[i]['value']);
                btn.appendTo(this.buttonsdiv);
            }
        }
        this.buttonsdiv
                .appendTo(this.form);
    },
    insertAlert: function () {
        this.divalert = $('<div></div>')
                .attr('id', this.form.attr('id') + '_result_container')
                .attr('role', 'alert')
                .hide();
        this.divalert
                .appendTo(this.form);
    },
    successmessage: function (message) {
        this.alertresult(
                message,
                true,
                this.options.alertdisplaytimeok,
                this.options.alertcommonclass + ' ' + this.options.alertsuccessclass,
                this.options.alertcommonclass + ' ' + this.options.alerterrorclass
                );
    },
    errormessage: function (message) {
        this.alertresult(
                message,
                false,
                this.options.alertdisplaytimefalse,
                this.options.alertcommonclass + ' ' + this.options.alertsuccessclass,
                this.options.alertcommonclass + ' ' + this.options.alerterrorclass
                );
    },
    alertresult: function (message, isok, delay, classok, classerror) {
        if (this.options.buildresultalert) {
            if (isok) {
                this.divalert.removeClass(classerror).
                        addClass(classok);
            } else {
                this.divalert.removeClass(classok).
                        addClass(classerror);
            }
            this.divalert.html(message).fadeIn("slow").delay(delay).fadeOut('slow');
        }
    }
}

var SebPasswordHelper = {
    input: null,
    confirminput: null,
    clearinput: null,
    oldinput: null,
    options: null,
    init: function (input, options) {
        this.input = $(input);
        this.options = options;
        if (this.options.confirminput != null) {
            var confirminput = $(this.options.confirminput);
            if (confirminput.length == 0 || confirminput.prop('tagName') != 'INPUT')
                throw 'error with confirminput';
            this.confirminput = confirminput;
        }
        if (this.options.clearinput != null) {
            var clearinput = $(this.options.clearinput);
            if (clearinput.length == 0 || clearinput.prop('tagName') != 'INPUT')
                throw 'error with clearinput';
            this.clearinput = clearinput;
        }
        if (this.options.oldinput != null) {
            var oldinput = $(this.options.oldinput);
            if (oldinput.length == 0 || oldinput.prop('tagName') != 'INPUT')
                throw 'error with oldinput';
            this.oldinput = oldinput;
        }
        var self = this;
        if (this.clearinput != null) {
            this.input.on('change', function () {
                self.copyval(self.input, self.clearinput);
            });
            this.clearinput.on('change', function () {
                self.copyval(self.clearinput, self.input);
            });
        }
        var sel1 = '.' + this.input.attr('id') + '-btn';
        $(sel1).each(function () {
            $(this).on('click', {self: self}, self._toggleInputs);
        });
        var sel2 = '.' + this.input.attr('id') + '-gen';
        $(sel2).each(function () {
            $(this).on('click', {self: self}, self._generate);
        });
    },
    _generate: function (e) {
        var self = e.data.self;
        self.generate();
    },
    generate: function () {
        var passregex = new RegExp(this.options.passregex);
        var pass = '';
        do {
            pass = '';
            for (var i = 0; i < this.options.genlength; i++) {
                let idx = Math.floor(Math.random() * Math.floor(this.options.passchars.length));
                pass += this.options.passchars[idx];
            }
        } while (passregex.exec(pass) == null);
        this.input.val(pass);
        if (this.confirminput != undefined) {
            this.confirminput.val(pass);
        }
        if (this.clearinput != undefined) {
            this.clearinput.val(pass);
        }
        $('#' + this.input.attr('id') + '-hidden-div').hide();
        $('#' + this.input.attr('id') + '-clear-div').show();
    },
    clearpass: function () {
        this.input.val('');
        if (this.confirminput != undefined) {
            this.confirminput.val('');
        }
        if (this.clearinput != undefined) {
            this.clearinput.val('');
        }
    },
    checkStrength: function () {
        $('#' + this.input.attr('id') + '-hidden-div').show();
        $('#' + this.input.attr('id') + '-clear-div').hide();
        //var passregex = new RegExp(this.options.passregex);
        return this.input.val() != '' && this.options.passregex.exec(this.input.val()) != null
    },
    checkIdentity: function () {
        return this.confirminput.val() != '' && this.input.val() == this.confirminput.val();
    },
    checkOldPass: function () {
        if (this.oldinput.val() == '') {
            return false;
        }
        if (this.options.checkoldpassurl != null) {
            var mydata = {};
            mydata[this.oldinput.attr('name')] = this.oldinput.val();
            var self = this;
            let returnval = false;
            $.ajax({
                url: self.options.checkoldpassurl,
                data: mydata,
                type: 'post',
                dataType: 'json',
                headers: {
                    'X-CSRF-Token': self.options.csrf
                },
                async: false,
                cache: false
            }).done(function (res) {
                if (self.options.checkoldpass_callback != null) {
                    returnval = self.options.checkoldpass_callback(res);
                } else {
                    returnval = self.checkpass_callback(res);
                }
            });
            return returnval;
        } else {
            return true;
        }
    },
    checkpass_callback: function (res) {
        if (res.ok) {
            return res.password_ok;
        }
        return false;
    },
    copyval: function (source, dest) {
        dest.val(source.val());
    },
    _toggleInputs: function (e) {
        var self = e.data.self;
        self.toggleInputs();
    },
    toggleInputs: function () {
        var sel = '.' + this.input.attr('id') + '-div';
        $(sel).each(function () {
            $(this).toggle();
        });
    }
};

var SebEmailHelper = {
    input: null,
    options: null,
    init: function (input, options) {
        this.input = $(input);
        this.options = options;
    },
    check: function () {
        return this.input.val() != '' && this.options.emailregex.exec(this.input.val()) != null
    },
};

var SebRichTextHelper = {
    div: null,
    divid: null,
    textareaid: null,
    options: null,
    savedcontent: null,
    init: function (div, options) {
        this.div = $(div);
        this.divid = this.div.prop('id');
        this.textareaid = this.div.find('textarea').prop('id'); //this.divid + '-input';
        this.options = options;
        this.build();
        this.save();
    },
    build: function () {
        $('#' + this.textareaid).richText(this.options);
    },
    content: function () {
        return $('#' + this.textareaid).val();
    },
    isEmpty: function () {
        return this.content() == '' || this.content() == '<p><br></p>';
    },
    hasChanged: function () {
        return this.content() != this.savedcontent;
    },
    save: function () {
        this.savedcontent = this.content();
    },
    loadContent: function (content) {
        $('#' + this.textareaid).val(content).trigger('change');
    }
};

if (typeof Object.create !== 'function') {
    Object.create = function (o) {
        function F() { } // optionally move this outside the declaration and into a closure if you need more speed.
        F.prototype = o;
        return new F();
    };
}
// rich text helper builder function
(function ($) {
    /* Create plugin */
    $.fn.sebFormHelper = function (options) {
        return this.each(function () {
            var element = $(this);
            if (element.prop('tagName') != 'FORM')
                throw '#' + element.prop('id') + ' not a FORM';
            if (element.data('sebformhelper'))
                return element.data('sebformhelper');
            var sebformhelper = Object.create(SebFormHelper);
            sebformhelper.init(this, options);
            element.data('sebformhelper', sebformhelper);
        });
    }
    //SebFormHelper
    $.fn.sebPasswordHelper = function (options) {
        return this.each(function () {
            var element = $(this);
            if (element.prop('tagName') != 'INPUT')
                throw  '#' + element.prop('id') + ' not a INPUT';
            if (element.data('sebpasswordhelper'))
                return element.data('sebpasswordhelper');
            var sebpasswordhelper = Object.create(SebPasswordHelper);
            sebpasswordhelper.init(this, options);
            element.data('sebpasswordhelper', sebpasswordhelper);
        });
    }
    $.fn.sebEmailHelper = function (options) {
        return this.each(function () {
            var element = $(this);
            if (element.prop('tagName') != 'INPUT')
                throw '#' + element.prop('id') + ' not a INPUT';
            if (element.data('sebemailhelper'))
                return element.data('sebemailhelper');
            var sebemailhelper = Object.create(SebEmailHelper);
            sebemailhelper.init(this, options);
            element.data('sebemailhelper', sebemailhelper);
        });
    }
    $.fn.sebRichTextHelper = function (options) {
        return this.each(function () {
            var element = $(this);
            if (element.prop('tagName') != 'DIV')
                throw '#' + element.prop('id') + ' not a DIV';
            // Return early if this element already has a plugin instance
            if (element.data('sebrichtexthelper'))
                return element.data('sebrichtexthelper');
            var sebrichtexthelper = Object.create(SebRichTextHelper);
            sebrichtexthelper.init(this, options);
            // pass options to plugin constructor
            element.data('sebrichtexthelper', sebrichtexthelper);
        });
    };
})($);
