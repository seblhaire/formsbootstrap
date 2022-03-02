var SebPasswordHelper = {
    input: null,
    confirminput : null,
    clearinput : null,
    options: null,
    init: function(input, options, confirminput, clearinput){
      this.input = input,
      this.options = options;
      this.confirminput = confirminput;
      this.clearinput = clearinput;
      var self = this;
      if (this.clearinput != undefined){
        this.input.on('change', function(){
          self.copyval(this, self.clearinput);
        });
        this.clearinput.on('change', function(){
          self.copyval(this, self.input);
        });
      }
    },
    generate : function(){
      var pass = '';
      do{
        pass = '';
        for (var i = 0; i < this.options.genlength; i++){
          idx = Math.floor(Math.random() * Math.floor(this.options.passchars.length));
          pass += this.options.passchars[idx];
        }
      }while(this.options.passregex.exec(pass) == null);
      this.input.val(pass);
      if (this.confirminput != undefined){
          this.confirminput.val(pass);
      }
      if (this.clearinput != undefined){
          this.clearinput.val(pass);
      }
    },
    clearpass: function(){
      this.input.val('');
      if (this.confirminput != undefined){
        this.confirminput.val('');
      }
      if (this.clearinput != undefined){
          this.clearinput.val('');
      }
    },
    checkStrength: function(){
      return this.options.passregex.exec(this.input.val()) != null
    },
    checkIdentity: function(){
      return this.input.val() == this.confirminput.val();
    },
    copyval: function(source, dest){
      dest.val(source.val());
    },
    toggleInputs: function(){
      this.input.toggle();
      this.clearinput.toggle();
    }
};

var SebRichTextHelper = {
  div : null,
  divid : null,
  textareaid : null,
  options : null,
  saveedcontent : null,
  init: function(div, options){
    this.div = jQuery(div);
    this.divid = this.div.prop('id');
    this.textareaid = this.divid + '-input';
    this.options = options;
    this.build();
    this.save();
  },
  build: function(){
    jQuery('#' + this.textareaid).richText(this.options);
  },
  content: function(){
    return jQuery('#' + this.textareaid).val();
  },
  isEmpty: function(){
    return this.content() == '' || this.content() == '<p><br></p>';
  },
  hasChanged: function(){
    return this.content() != this.saveedcontent;
  },
  save: function(){
    this.saveedcontent = this.content();
  },
  loadContent: function(content){
    jQuery('#' + this.textareaid).val(content).trigger('change');
  }
};

if (typeof Object.create !== 'function') {
	Object.create = function(o) {
		function F() { } // optionally move this outside the declaration and into a closure if you need more speed.
		F.prototype = o;
		return new F();
	};
}
// rich text helper builder function
(function(jQuery) {
	/* Create plugin */
  jQuery.fn.sebPasswordHelper = function(options, confirminput, clearinput){
    return this.each(function() {
			var element = jQuery(this);
			if (element.prop('tagName') != 'INPUT') throw 'not a INPUT';
      if (confirminput != undefined && confirminput.prop('tagName') != 'INPUT') throw 'confirminput not a INPUT';
      if (clearinput != undefined && clearinput.prop('tagName') != 'INPUT') throw 'clearinput not a INPUT';
      if (element.data('sebpasswordhelper')) return element.data('sebpasswordhelper');
      var sebpasswordhelper = Object.create(SebPasswordHelper);
      sebpasswordhelper.input(this, options, confirminput, clearinput);
      element.data('sebpasswordhelper', sebpasswordhelper);
    });
  }
	jQuery.fn.sebRichTextHelper = function(options)  {
		return this.each(function() {
			var element = jQuery(this);
			if (element.prop('tagName') != 'DIV') throw 'not a DIV';
			// Return early if this element already has a plugin instance
			if (element.data('sebrichtexthelper')) return element.data('sebrichtexthelper');
			var sebrichtexthelper = Object.create(SebRichTextHelper);
			sebrichtexthelper.init(this, options);
			// pass options to plugin constructor
			element.data('sebrichtexthelper', sebrichtexthelper);
		});
	};
})(jQuery);

SebFormsBootstrapClearOnClick = function(params){
  jQuery("#" + params.formId + " ." + params.requiredId).each(function(i){
    jQuery(this).on( "click", function() {
      jQuery(this).removeClass('is-invalid').removeClass('is-valid');
    });
  });
  jQuery("#" + params.formId + " ." + params.requiredCheckedId).each(function(i){
    jQuery(this).on( "click", function() {
      jQuery(this).removeClass('is-invalid').removeClass('is-valid');
    });
  });
  jQuery("#" + params.formId + " ." + params.requiredMailId).each(function(i){
    jQuery(this).on( "click", function() {
      jQuery(this).removeClass('is-invalid').removeClass('is-valid');
    });
  });
  jQuery("#" + params.formId + " ." + params.requiredPassId).each(function(i){
    jQuery(this).on( "click", function() {
      jQuery(this).removeClass('is-invalid').removeClass('is-valid');
    });
  });
  jQuery("#" + params.formId + " ." + params.requiredSpecialId).each(function(i){
    jQuery(this).on( "click", function() {
      jQuery(this).find('.is-invalid').removeClass('is-invalid').removeClass('is-valid');
    });
  });
}

SebFormsBootstrapResetForm = function(params){
  jQuery("#" + params.formId + " ." + params.requiredId).each(function(i){
    jQuery(this).removeClass('is-invalid').removeClass('is-valid');
  });
  jQuery("#" + params.formId + " ." + params.requiredCheckedId).each(function(i){
    jQuery(this).removeClass('is-invalid').removeClass('is-valid');
  });
  jQuery("#" + params.formId + " ." + params.requiredMailId).each(function(i){
    jQuery(this).removeClass('is-invalid').removeClass('is-valid');
  });
  jQuery("#" + params.formId + " ." + params.requiredPassId).each(function(i){
    jQuery(this).removeClass('is-invalid').removeClass('is-valid');
  });
  jQuery("#" + params.formId + " ." + params.requiredSpecialId).each(function(i){
    jQuery(this).find('.is-invalid').removeClass('is-invalid').removeClass('is-valid');
  });
}

SebFormsBootstrapValidateForm = function(params){
  var isValid = true;
  jQuery("#" + params.formId + " ." + params.requiredId).each(function(i){
    if (jQuery(this).val() == ''){
      isValid = false;
      jQuery(this).addClass('is-invalid');
    }else{
      jQuery(this).addClass('is-valid');
    }
  });
  jQuery("#" + params.formId + " ." + params.requiredSelcheckId).each(function(i){
    var checked = false;
    jQuery(this).find('input').each(function(j){
      if (jQuery(this).prop('checked')){
        checked = true;
      }
    });
    if (checked){
      jQuery(this).find('.' + params.requiredCheckedId).first().addClass('is-valid');
    }else{
      isValid = false;
      jQuery(this).find('.' + params.requiredCheckedId).first().addClass('is-invalid');
    }
  });
  jQuery("#" + params.formId + " ." + params.requiredMailId).each(function(i){
    if (!jQuery(this).val().match(params.emailregex)){
      isValid = false;
      jQuery(this).addClass('is-invalid');
    }else{
      jQuery(this).addClass('is-valid');
    }
  });
  jQuery("#" + params.formId + " ." + params.requiredPassId).each(function(i){
    if (!jQuery(this).val().match(params.passregex)){
      isValid = false;
      jQuery(this).addClass('is-invalid');
    }else{
      jQuery(this).addClass('is-valid');
    }
  });
  jQuery("#" + params.formId + " ." + params.requiredSpecialId).each(function(i){
    if (jQuery(this).data('sebrichtexthelper') != undefined){
      if (jQuery(this).data('sebrichtexthelper').isEmpty()){
        isValid = false;
        jQuery(this).find('.richText').addClass('is-invalid');
      }else{
        jQuery(this).find('.richText').addClass('is-valid');
      }
    }
    if (jQuery(this).data('uploader') != undefined){
      if (jQuery(this).data('uploader').getresultprocessor().countFiles() == 0){
        isValid = false;
        jQuery(this).find('.uploader').addClass('is-invalid');
      }else{
        jQuery(this).find('.uploader').addClass('is-valid');
      }
    }
    if (jQuery(this).data('tagsinput') != undefined){
      if (jQuery(this).data('tagsinput').count() == 0){
        isValid = false;
        jQuery(this).data('tagsinput').autocompleter.addClass('is-invalid');
      }else{
        jQuery(this).data('tagsinput').autocompleter.addClass('is-valid');
      }
    }
  });
  return isValid;
}
