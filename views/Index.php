<?php
    if (isset($_GET['error'])) {
        echo '<div>' . $_GET['error'] . '</div>';
    }
?>
<div>
    <center>
        <form method='POST' action='index.php'>
            <select name='loginForm[airline]'>
                <option value='' selected disabled hidden>Choose Airline</option>
                <?php foreach ($data as $airline) {
                    echo '<option value="' . $airline->id  . '">' . $airline->name . '</option>';
                } ?>
            </select>
            <br />
            <input name='loginForm[user]' type='text' placeholder='User' />
            <br />
            <input name='loginForm[password]' type='password' placeholder='Password' />
            <br />
            <button type='submit'>Sign in</button>
        </form>
    </center>
</div>