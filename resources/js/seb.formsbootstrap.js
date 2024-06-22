var SebFormHelper = {
    form: null,
    divalert: null,
    buttonsdiv: null,
    options: null,
    savedData: null,
    init: function (form, options) {
        this.form = jQuery(form);
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
            jQuery(window).bind('beforeunload', {self: this}, this.pageleave);
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
        jQuery('input[type=checkbox]').each(function () {
            jQuery(this).prop('checked', false)
        });
        jQuery('input[type=radio]').each(function () {
            jQuery(this).prop('checked', false)
        });
        jQuery('option').each(function () {
            jQuery(this).prop('selected', false)
        });
        jQuery.each(res, function (key, value) {
            if (jQuery('#' + key).data('sebrichtexthelper') != undefined) {
                //console.log('rth ' + key);
                jQuery('#' + key).data('sebrichtexthelper').loadContent(value);
            } else if (jQuery('#' + key).data('uploader') != undefined) {
                //console.log('upl ' + key);
                jQuery('#' + key).data('uploader').reset();
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
                jQuery('#' + key).data('uploader').getresultprocessor().process(result);
            } else if (jQuery('#' + key).data('tagsinput') != undefined) {
                jQuery('#' + key).data('tagsinput').reset();
                jQuery('#' + key).data('tagsinput').addtolist(value);
            } else if (jQuery('#' + key).data('sebdaterangepicker') != undefined) {
                //console.log('date ' + key);
                if (Array.isArray(value)) {
                    jQuery('#' + key).data('sebdaterangepicker').setDoubleCalendar(moment(value[0]), moment(value[1]));
                } else {
                    jQuery('#' + key).data('sebdaterangepicker').setSingleCalendar(moment(value));
                }
            } else if (
                    jQuery('#' + key).length > 0 && (
                    jQuery('#' + key)[0].tagName == 'TEXTAREA' ||
                    (
                            jQuery('#' + key)[0].tagName == 'INPUT' &&
                            (
                                    jQuery('#' + key)[0].type == 'text' ||
                                    jQuery('#' + key)[0].type == 'hidden' ||
                                    jQuery('#' + key)[0].type == 'number' ||
                                    jQuery('#' + key)[0].type == 'color' ||
                                    jQuery('#' + key)[0].type == 'range' ||
                                    jQuery('#' + key)[0].type == 'email'
                                    )
                            )
                    )
                    ) {
                //console.log('in ' + key);
                jQuery('#' + key).val(value).trigger('input');
            } else if (
                    jQuery('#' + key).length > 0 &&
                    jQuery('#' + key)[0].tagName == 'SELECT'
                    ) {
                if (!Array.isArray(value)) {
                    value = [value];
                }
                for (i in value) {
                    jQuery('#' + key + ' option[value=' + value[i].toString() + ']').prop('selected', true)
                }
            } else if (jQuery('input[type=checkbox][name=' + jQuery.escapeSelector(key + '[]') + ']').length > 0) {
                for (i in value) {
                    jQuery('input[type=checkbox][name=' + jQuery.escapeSelector(key + '[]') + '][value=' + value[i].toString() + ']').prop('checked', true);
                }
            } else if (jQuery('input[type=radio][name=' + jQuery.escapeSelector(key) + ']').length > 0) {
                jQuery('input[type=radio][name=' + jQuery.escapeSelector(key) + '][value=' + value + ']').prop('checked', true);
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
            jQuery('#' + self.form.attr('id') + '_submit_spinner').show();
            jQuery.ajax({
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
                        jQuery('#' + self.form.attr('id') + '_submit_spinner').hide();
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
                        jQuery('#' + self.form.attr('id') + '_submit_spinner').hide();
                        if (jqXHR.status == 419) {
                            self.errormessage(self.options.tokenexpired);
                        } else if (jqXHR.status == 403){
                            self.errormessage(self.options.nonauthorized);
                        } else if (jqXHR.status == 422){
                            var response = jQuery.parseJSON(jqXHR.responseText);
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
                jQuery(data).each(function (i, elt) {
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
        jQuery("#" + this.form.attr('id') + " ." + this.options.requiredclass).each(function (i) {
            jQuery(this).removeClass('is-invalid').removeClass('is-valid');
        });
        jQuery("#" + this.form.attr('id') + " ." + this.options.requiredcheckclass).each(function (i) {
            jQuery(this).removeClass('is-invalid').removeClass('is-valid');
        });
        jQuery("#" + this.form.attr('id') + " ." + this.options.verifymailclass).each(function (i) {
            jQuery(this).removeClass('is-invalid').removeClass('is-valid');
        });
        jQuery("#" + this.form.attr('id') + " ." + this.options.verifypassclass).each(function (i) {
            jQuery(this).removeClass('is-invalid').removeClass('is-valid');
        });
        jQuery("#" + this.form.attr('id') + " ." + this.options.verifypassmatchclass).each(function (i) {
            jQuery(this).removeClass('is-invalid').removeClass('is-valid');
        });
        jQuery("#" + this.form.attr('id') + " ." + this.options.verifypassold).each(function (i) {
            jQuery(this).removeClass('is-invalid').removeClass('is-valid');
        });
        jQuery("#" + this.form.attr('id') + " ." + this.options.requiredspecialclass).each(function (i) {
            jQuery(this).find('.is-invalid').removeClass('is-invalid').removeClass('is-valid');
        });
        if (this.options.remove_validation_function != null) {
            this.options.remove_validation_function();
        }
    },
    clearonclick: function () {
        jQuery("#" + this.form.attr('id') + " ." + this.options.requiredclass).each(function (i) {
            jQuery(this).on("click", function () {
                jQuery(this).removeClass('is-invalid').removeClass('is-valid');
            });
        });
        jQuery("#" + this.form.attr('id') + " ." + this.options.requiredcheckclass).each(function (i) {
            jQuery(this).on("click", function () {
                jQuery(this).removeClass('is-invalid').removeClass('is-valid');
            });
        });
        jQuery("#" + this.form.attr('id') + " ." + this.options.verifymailclass).each(function (i) {
            jQuery(this).on("click", function () {
                jQuery(this).removeClass('is-invalid').removeClass('is-valid');
            });
        });
        jQuery("#" + this.form.attr('id') + " ." + this.options.verifypassclass).each(function (i) {
            jQuery(this).on("click", function () {
                jQuery(this).removeClass('is-invalid').removeClass('is-valid');
            });
        });
        jQuery("#" + this.form.attr('id') + " ." + this.options.verifypassmatchclass).each(function (i) {
            jQuery(this).on("click", function () {
                jQuery(this).removeClass('is-invalid').removeClass('is-valid');
            });
        });
        jQuery("#" + this.form.attr('id') + " ." + this.options.verifypassold).each(function (i) {
            jQuery(this).on("click", function () {
                jQuery(this).removeClass('is-invalid').removeClass('is-valid');
            });
        });
        jQuery("#" + this.form.attr('id') + " ." + this.options.requiredspecialclass).each(function (i) {
            jQuery(this).on("click", function () {
                jQuery(this).find('.is-invalid').removeClass('is-invalid').removeClass('is-valid');
            });
        });
        if (this.options.clearonclick_function != null) {
            this.options.clearonclick_function();
        }
    },
    validate: function () {
        var self = this;
        var isValid = true;
        jQuery("#" + self.form.attr('id') + " ." + self.options.requiredclass).each(function (i) {
            if (jQuery(this).val() == '') {
                isValid = false;
                jQuery(this).addClass('is-invalid');
            } else {
                jQuery(this).addClass('is-valid');
            }
        });
        jQuery("#" + self.form.attr('id') + " ." + self.options.selcheckclass).each(function (i) {
            var checked = false;
            jQuery(this).find('input').each(function (j) {
                if (jQuery(this).prop('checked')) {
                    checked = true;
                }
            });
            if (checked) {
                jQuery(this).find('.' + self.options.requiredcheckclass).first().addClass('is-valid');
            } else {
                isValid = false;
                jQuery(this).find('.' + self.options.requiredcheckclass).first().addClass('is-invalid');
            }
        });
        jQuery("#" + self.form.attr('id') + " ." + self.options.verifymailclass).each(function (i) {
            if (!jQuery(this).data('sebemailhelper').check()) {
                isValid = false;
                jQuery(this).addClass('is-invalid');
            } else {
                jQuery(this).addClass('is-valid');
            }
        });
        jQuery("#" + self.form.attr('id') + " ." + self.options.verifypassclass).each(function (i) {
            if (!jQuery(this).data('sebpasswordhelper').checkStrength()) {
                isValid = false;
                jQuery(this).addClass('is-invalid');
            } else {
                jQuery(this).addClass('is-valid');
            }
        });
        jQuery("#" + self.form.attr('id') + " ." + self.options.verifypassmatchclass).each(function (i) {
            if (!jQuery(jQuery(this).data('maininput')).data('sebpasswordhelper').checkIdentity()) {
                isValid = false;
                jQuery(this).addClass('is-invalid');
            } else {
                jQuery(this).addClass('is-valid');
            }
        });
        jQuery("#" + self.form.attr('id') + " ." + self.options.verifypassold).each(function (i) {
            if (!jQuery(jQuery(this).data('maininput')).data('sebpasswordhelper').checkOldPass()) {
                isValid = false;
                jQuery(this).addClass('is-invalid');
            } else {
                jQuery(this).addClass('is-valid');
            }
        });
        jQuery("#" + self.form.attr('id') + " ." + self.options.requiredspecialclass).each(function (i) {
            if (jQuery(this).data('sebrichtexthelper') != undefined) {
                if (jQuery(this).data('sebrichtexthelper').isEmpty()) {
                    isValid = false;
                    jQuery(this).find('.richText').addClass('is-invalid');
                } else {
                    jQuery(this).find('.richText').addClass('is-valid');
                }
            }
            if (jQuery(this).data('uploader') != undefined) {
                if (jQuery(this).data('uploader').getresultprocessor().countFiles() == 0) {
                    isValid = false;
                    jQuery(this).find('.uploader').addClass('is-invalid');
                } else {
                    jQuery(this).find('.uploader').addClass('is-valid');
                }
            }
            if (jQuery(this).data('tagsinput') != undefined) {
                if (jQuery(this).data('tagsinput').count() == 0) {
                    isValid = false;
                    jQuery(this).data('tagsinput').autocompleter.addClass('is-invalid');
                } else {
                    jQuery(this).data('tagsinput').autocompleter.addClass('is-valid');
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
            jQuery('#' + obj.key).val(obj.value);
        }
        jQuery('select option').each(function (e) {
            $(this).prop('selected', false)
        });
        jQuery('input[type=radio]').each(function (e) {
            $(this).prop('checked', false)
        });
        jQuery('input[type=checkbox]').each(function (e) {
            $(this).prop('checked', false)
        });
        jQuery("#" + this.form.attr('id') + " ." + this.options.resettextclass).each(function (i) {
            jQuery(this).val('').trigger('input');
        });
        jQuery("#" + this.form.attr('id') + " ." + this.options.resetselectclass).each(function (i) {
            jQuery(this).find('option').each(function (j) {
                if (jQuery(this).attr('defaultchecked') == 'defaultchecked') {
                    jQuery(this).prop('selected', true);
                }
            });
        });
        jQuery("#" + this.form.attr('id') + " ." + this.options.resetradioclass).each(function (i) {
            jQuery(this).find('input').each(function (j) {
                if (jQuery(this).attr('defaultchecked') == 'defaultchecked') {
                    jQuery(this).prop('checked', true);
                }
            });
        });
        jQuery("#" + this.form.attr('id') + " ." + this.options.resetcheckclass).each(function (i) {
            jQuery(this).find('input').each(function (j) {
                if (jQuery(this).attr('defaultchecked') == 'defaultchecked') {
                    jQuery(this).prop('checked', true);
                }
            });
        });
        jQuery("#" + this.form.attr('id') + " ." + this.options.resetspecialclass).each(function (i) {
            if (jQuery(this).data('sebrichtexthelper') != undefined) {
                jQuery(this).data('sebrichtexthelper').loadContent('');
            }
            if (jQuery(this).data('uploader') != undefined) {
                jQuery(this).data('uploader').reset();
            }
            if (jQuery(this).data('tagsinput') != undefined) {
                jQuery(this).data('tagsinput').reset();
            }
            if (jQuery(this).data('sebdaterangepicker') != undefined) {
                jQuery(this).data('sebdaterangepicker').reset();
            }
        });
        if (this.options.clear_function != null) {
            isValid = this.options.clear_function();
        }
        this.save();
    },
    insertButtons: function () {
        this.buttonsdiv = jQuery('<div></div>')
                .attr('id', this.form.attr('id') + '_buttons')
                .addClass(this.options.buttondivclass)
        var text = jQuery('<span></span>')
                .attr('id', this.form.attr('id') + '_submit_text').html(this.options.submitbtnlbl);
        var spinner = jQuery('<i></i>')
                .attr('id', this.form.attr('id') + '_submit_spinner')
                .addClass("fa-solid fa-spinner fa-spin-pulse")
                .hide();
        jQuery('<button></button>')
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
                var btn = jQuery('<button></button>')
                        .attr('type', 'button');
                jQuery.map(this.options.additionalbuttons[i], function (value, key) {
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
        this.divalert = jQuery('<div></div>')
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
        this.input = jQuery(input);
        this.options = options;
        if (this.options.confirminput != null) {
            var confirminput = jQuery(this.options.confirminput);
            if (confirminput.length == 0 || confirminput.prop('tagName') != 'INPUT')
                throw 'error with confirminput';
            this.confirminput = confirminput;
        }
        if (this.options.clearinput != null) {
            var clearinput = jQuery(this.options.clearinput);
            if (clearinput.length == 0 || clearinput.prop('tagName') != 'INPUT')
                throw 'error with clearinput';
            this.clearinput = clearinput;
        }
        if (this.options.oldinput != null) {
            var oldinput = jQuery(this.options.oldinput);
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
        jQuery(sel1).each(function () {
            jQuery(this).on('click', {self: self}, self._toggleInputs);
        });
        var sel2 = '.' + this.input.attr('id') + '-gen';
        jQuery(sel2).each(function () {
            jQuery(this).on('click', {self: self}, self._generate);
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
                idx = Math.floor(Math.random() * Math.floor(this.options.passchars.length));
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
        jQuery('#' + this.input.attr('id') + '-hidden-div').hide();
        jQuery('#' + this.input.attr('id') + '-clear-div').show();
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
        jQuery('#' + this.input.attr('id') + '-hidden-div').show();
        jQuery('#' + this.input.attr('id') + '-clear-div').hide();
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
            returnval = false;
            jQuery.ajax({
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
        jQuery(sel).each(function () {
            jQuery(this).toggle();
        });
    }
};

var SebEmailHelper = {
    input: null,
    options: null,
    init: function (input, options) {
        this.input = jQuery(input);
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
        this.div = jQuery(div);
        this.divid = this.div.prop('id');
        this.textareaid = this.div.find('textarea').prop('id'); //this.divid + '-input';
        this.options = options;
        this.build();
        this.save();
    },
    build: function () {
        jQuery('#' + this.textareaid).richText(this.options);
    },
    content: function () {
        return jQuery('#' + this.textareaid).val();
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
        jQuery('#' + this.textareaid).val(content).trigger('change');
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
(function (jQuery) {
    /* Create plugin */
    jQuery.fn.sebFormHelper = function (options) {
        return this.each(function () {
            var element = jQuery(this);
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
    jQuery.fn.sebPasswordHelper = function (options) {
        return this.each(function () {
            var element = jQuery(this);
            if (element.prop('tagName') != 'INPUT')
                throw  '#' + element.prop('id') + ' not a INPUT';
            if (element.data('sebpasswordhelper'))
                return element.data('sebpasswordhelper');
            var sebpasswordhelper = Object.create(SebPasswordHelper);
            sebpasswordhelper.init(this, options);
            element.data('sebpasswordhelper', sebpasswordhelper);
        });
    }
    jQuery.fn.sebEmailHelper = function (options) {
        return this.each(function () {
            var element = jQuery(this);
            if (element.prop('tagName') != 'INPUT')
                throw '#' + element.prop('id') + ' not a INPUT';
            if (element.data('sebemailhelper'))
                return element.data('sebemailhelper');
            var sebemailhelper = Object.create(SebEmailHelper);
            sebemailhelper.init(this, options);
            element.data('sebemailhelper', sebemailhelper);
        });
    }
    jQuery.fn.sebRichTextHelper = function (options) {
        return this.each(function () {
            var element = jQuery(this);
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
})(jQuery);
