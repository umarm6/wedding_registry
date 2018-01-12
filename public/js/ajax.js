
jQuery(document).ready(function(){
    
      jQuery(document).on('click','.buy_this',function(event){
                alert('asdad');
                            event.preventDefault();

                var data = {
            'action': 'my_action',
            'whatever': 12,      // We pass php values differently!
        };
    
                var fruit = 'Banana';
                jQuery.post(ajax_object.ajax_url, data, function(response) {
            alert('Got this from the server: ' + response);
        });
        //         $.ajax({
        //     url: ajax_object.ajax_url, // or example_ajax_obj.ajaxurl if using on frontend
        //     data: {
        //         'action': 'my_action',
        //         'fruit' : fruit
        //     },
        //     success:function(data) {
        //         // This outputs the result of the ajax request
        //         console.log(data);
        //     },
        //     error: function(errorThrown){
        //         console.log(errorThrown);
        //     }
        // });   
                //  jQuery(this).notify(
                //             "Item Is added to Cart", 
                //             { position:"bottom center", className: "success"  }
                //           );
                });
              });

