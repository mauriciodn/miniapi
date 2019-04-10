<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <title>Hotels</title>
    </head>
    <body>        
        <div>
            <center>
                <form id='searchForm' method='GET' action='forms/AjaxSearch.php'>
                    <input id='destination' name='hotelSearchForm[destination]' type='text' placeholder='Select a destination...' />
                    <br />
                    <input id='checkin' name='hotelSearchForm[checkin]' type='date' />
                    <br />
                    <input id='checkout' name='hotelSearchForm[checkout]' type='date' />
                    <br />
                    <select id='guests' name="hotelSearchForm[guests]">
                        <?php for ($i = 1; $i <= 24; $i++) : ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                    <br />
                    <button id='searchButton' type='submit'>Search</button>
                </form>
            </center>
        </div>
        <div id='searchResults'>
            
        </div>
    </body>
</html>

<script type="text/javascript">
    $(document).ready(function(){
        $('#searchForm').submit(function(event) {
            event.preventDefault();
            var $form = $(this),
                actionUrl = $form.attr('action');            
            $.get(
                actionUrl,
                $(this).serialize(),
                function(data) {
                    console.log(data);
                    //handle data and append to #searchResults

            }).fail(function(response) {
                console.log(response);
            });
        });
    });
</script>