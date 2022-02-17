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
// table builder function
(function(jQuery) {
	/* Create plugin */
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

/**
 * generates passwprd following rules
 * @param  string passcharsalid characters to generate pass
 * @param  regex passregex regular expression to validate passwprd
 * @param  int length    password length
 * @param  JqueryObj[] inputs array of objs fields to fill with èassword ex: jQuery('#passwotd')
 * @return void
 */
SebFormsBootstrapGeneratepass = function(passchars, passregex, length, inputs){
  var pass = '';
  do{
    pass = '';
    for (var i = 0; i < length; i++){
      idx = Math.floor(Math.random() * Math.floor(passchars.length));
      pass += passchars[idx];
    }
  }while(passregex.exec(pass) == null);
  jQuery(inputs).each(function() {
      this.val(pass);
  });
};

/**
 * clears input fields
 * @param  JqueryObj[] fields array of objs fields to cleai ex: jQuery('#passwotd')
 * @return void
 */
SebFormsBootstrapClearpass = function(fields){
  jQuery(fields).each(function() {
      this.val('');
  });
}
SebFormsBootstrapClearOnClick = function(params){
  jQuery("#" + params.formId + " ." + params.requiredId).each(function(i){
    jQuery(this).bind( "click", function() {
      jQuery(this).removeClass('is-invalid').removeClass('is-valid');
    });
  });
  jQuery("#" + params.formId + " ." + params.requiredCheckedId).each(function(i){
    jQuery(this).bind( "click", function() {
      jQuery(this).removeClass('is-invalid').removeClass('is-valid');
    });
  });
  jQuery("#" + params.formId + " ." + params.requiredMailId).each(function(i){
    jQuery(this).bind( "click", function() {
      jQuery(this).removeClass('is-invalid').removeClass('is-valid');
    });
  });
  jQuery("#" + params.formId + " ." + params.requiredPassId).each(function(i){
    jQuery(this).bind( "click", function() {
      jQuery(this).removeClass('is-invalid').removeClass('is-valid');
    });
  });
  jQuery("#" + params.formId + " ." + params.requiredSpecialId).each(function(i){
    jQuery(this).bind( "click", function() {
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
      console.log(jQuery(this).data('uploader').getresultprocessor().countFiles());
      if (jQuery(this).data('uploader').getresultprocessor().countFiles() == 0){
        isValid = false;
        jQuery(this).find('.uploader').addClass('is-invalid');
      }else{
        jQuery(this).find('.uploader').addClass('is-valid');
      }
    }
  });
  return isValid;
}
