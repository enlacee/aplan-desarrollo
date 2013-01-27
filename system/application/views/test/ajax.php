<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
    <script language='JavaScript' type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js'></script>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
        <title>Display Page</title>
    </head>
    <body>
        
        <button type='button' name='getdata' id='getdata'>Get Data.</button>
        
        <div id='result_table'></div>
 
        <script type='text/javascript' language='javascript'>
            $('#getdata').click( function() {
                $.ajax( {
                    url         :   '<?php echo base_url().'get_all_users' ?>',
                    type        :   'POST',
                    dataType    :   'json',
                    success     :   function( output_string ) {
                        $('#result_table').append( output_string );
                    } // fin de la funcion SUCCESS con AJAX
                } ); // fin de la llamada a AJAX
            } );
        </script>
        
    </body>
</html>
