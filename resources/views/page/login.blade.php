<?php
$MODULE = 'Login';
?>

<div class="talCnt row">
    <div class="col-12">
        <h2 class="talCnt">{{ $MODULE }}</h2>
    </div>

    <div class="col-4">
    </div>
    <div class="col-4">
        <form method="post">
            <input type="text" name="username" placeholder="Username" /><br/><br/>
            <input type="password" name="password" placeholder="Password" /><br/><br/>
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <input type="submit" value="Submit" />
        </form>
    </div>
    <div class="col-4">
    </div>
</div>