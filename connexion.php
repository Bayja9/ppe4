<?php
<script>

$(document).on('pageinit', '#loggin', function(){
    $(document).on('click', '#submit', function() { // catch the form's submit event
        if($('#login').val().length > 0 && $('#mdp').val().length > 0){
            // Send data to server through the Ajax call
            // action is functionality we want to call and outputJSON is our data
                $.ajax({url: 'http://localhost:8888/Apeiron/server/data.php',
                    data: {'action' : 'Connexion', 'login': $('#login').val(), 'mdp':$('#mdp').val()},
                    type: 'get',
                    async: 'true',
                    dataType: 'json',
//                    beforeSend: function() {
//                        // This callback function will trigger before data is sent
//                        $.mobile.loading('show', {theme:"a", text:"Please wait...", textonly:true, textVisible: true}); // This will show ajax spinner
//                    },
//                    complete: function() {
//                        // This callback function will trigger on data sent/received complete
//                        $.mobile.loading('hide'); // This will hide ajax spinner
//                    },
                    success: function (result) {
                        if(result.success) {
                            alert(result.success);
                            $.mobile.changePage("#second");
                        } else {
                            alert('Logon unsuccessful! ' + result.status);
                        }
                    },
                    error: function (request,error) {
                        // This callback function will trigger on unsuccessful action
                        alert('error Connexion : ' + error + ' request Connexion : ' + request);
                    }
                });
        } else {
            alert('Please fill all necessary fields!');
        }
        return false; // cancel original event to prevent form submitting
		//makeCorsRequest();
    });
});

$(document).on('pagebeforeshow', '#second', function(){
    $.mobile.activePage.find('.ui-content').html('Welcome ' + $('#login').val());
    $.ajax({url: 'http://localhost:8888/Apeiron/server/data.php',
                    data: {'action' : 'SelectGroupes'},
                    type: 'get',
                    async: 'true',
                    dataType: 'json',
                    beforeSend: function() {
                        // This callback function will trigger before data is sent
                        $.mobile.loading('show', {theme:"a", text:"Please wait...", textonly:true, textVisible: true}); // This will show ajax spinner
                    },
                    complete: function() {
                        // This callback function will trigger on data sent/received complete
                        $.mobile.loading('hide'); // This will hide ajax spinner
                    },
                    success: function (result) {
                        if(result.success) {
                            alert(result.success);
                            $.mobile.changePage("#second");
                        } else {
                            alert('Logon unsuccessful! ' + result.status);
                        }
                    },
                    error: function (request,error) {
                        // This callback function will trigger on unsuccessful action
                        alert('error SelectGroupe : ' + error + ' request SelectGroupe : ' + request);
                    }
                });
});
</script>
?>
