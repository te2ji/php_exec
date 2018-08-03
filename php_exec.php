<?php
/**
 * MIT License
 *
 * Copyright (c) 2018 te2ji
 *
 *  Permission is hereby granted, free of charge, to any person obtaining a copy
 *  of this software and associated documentation files (the "Software"), to deal
 *  in the Software without restriction, including without limitation the rights
 *  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 *  copies of the Software, and to permit persons to whom the Software is
 *  furnished to do so, subject to the following conditions:
 *
 *  The above copyright notice and this permission notice shall be included in all
 *  copies or substantial portions of the Software.
 *
 *  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 *  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 *  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 *  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 *  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 *  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 *  SOFTWARE.
 **/

function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

$command = filter_input(INPUT_POST, 'command');
if ($command) {
    $res_arr = array($command);
    exec($command, $arr, $res);
    if ($res === 0) {
        foreach ($arr as $val) {
            $res_arr[] = ($val) ? h($val) : '';
        }
    } else {
        $res_arr[] = 'command error !';
    }
    $res_json = json_encode($res_arr);
    header("Content-Type: application/json");
    echo $res_json;
    exit();
}
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>php_exec</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
    </head>
    <body>
        <div  class="container" style="background-color:#444;color:#FFF">
            <h1 class="display-4">php_exec</h1>
            <p class="lead">使用後このファイルは必ず削除してください。</p>
            <div class="input-group" style="background-color:#111;">
                <input type="text" class="form-control" id ="command" placeholder="ここに実行コマンドを入力してください。">
                <div class="input-group-append">
                    <span class="input-group-text" id="exec">実行</span>
                </div>
            </div>
            <textarea class="form-control col-12 result" style="background-color:#111;color:#FFF;" rows="30">実行結果がここに表示されます。</textarea>
            <script type="text/javascript">
                $(function(){
                    $('#exec').click(function(){
                        $('.result').html('実行中');
                        $.ajax({
                            url:'php_exec.php',
                            type:'POST',
                            data:{
                                'command':$('#command').val(),
                            },
                            dataType: 'json',
                        })
                        .done(function(data){
                            $('.result').html('');
                            for (var i =0; i<data.length; i++) {
                                let $content = $('.result');
                                $content.append(data[i]+"\n");
                            }
                        })
                        .fail(function(XMLHttpRequest, textStatus, errorThrown){
                            alert(errorThrown);
                        });
                    });
                });
            </script>
        </div>
    </body>
</html>