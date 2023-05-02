 // var ajax={
 // 	"method" : "post",
 // 	"data" : [],
 // 	"url" : "http://localhost/Project/newmvc-dhruvtilva/Index.php?c=ajax&a=response",
 // 	'call' : function (){

 // 		var action = $("#ajaxForm").attr('action');
 // 		console.log(action);

 // 		$.ajax({
 // 			method: "POST",
 // 			url: action,
 // 			data:{ name: "dhruv", location: "ahmedabad"}
 // 		})

 // 		.done(function(msg){
 // 			console.log("data saved:"+ msg);
 // 		});
 // 	}

 // }; 

 // ajax.call();


var ajax = {
            form : null,
            method : 'get',
            url : 'amazon.com',
            params : {},

            setForm:function(formId){
                this.form = $("#"+formId);
                return this;
            },

            getForm:function(){
                return this.form;
            },

            setMethod:function(method){
                this.method = method;
                return this;
            },

            getMethod:function(){
                return this.method;
            },

            setUrl:function(url){
                this.url = url;
                return this;
            },

            getUrl:function(){
                return this.url;
            },

            setParams:function(params){
                this.params = params;
                return this;
            },

            getParams:function(key=null){
                if (key === null) {
                    return this.params;
                }

                if (this.params[key] === undefined) {
                    return null;
                }
                return this.params[key];
            },

            prepareRequestSettings:function(){
                if (this.getForm()){
                    this.setMethod(this.getForm().attr('method'));
                    this.setParams(this.getForm().serializeArray());
                }
            },

            resetRequestSettings:function(){
                this.setParams({});
                this.setMethod('get');
                return this;
            },

            call : function(){
                let self = this;
                this.prepareRequestSettings();
                $.ajax({
                    url : this.getUrl(),
                    type : this.getMethod(),
                    data : this.getParams(),
                    dataType: 'json'
                }).done(function(response) {
                    $('#'+response.element).html(response.html);
                    self.resetRequestSettings();
                });
            }

        };

