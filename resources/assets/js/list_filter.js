function filter(element) {
       var value = $(element).val();

       $("#users_list > li:not(:first)").each(function() {
           if ($(this).text().search(value) > -1) {
               $(this).show();
           }
           else {
               $(this).hide();
           }
       });
   }
//TODO Make it more reusable 
