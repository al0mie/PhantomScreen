<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" type="text/css">
        <style>
            
        .page-size-input {
            width: 80px;
            display: inline-flex;
        }

        .size-input-little {
            width: 70px;
            display: inline-flex;
        }

        .quality-percent {
            font-size: 20px;
        }


        .add-url-container {
            width: 100%;
            display: inline-flex;
            padding-bottom: 10px;
        }

        .links {
            display: table;
        }
            
    </style>

    </head>
    <body>
        <div class="container">
    {!! Form::open(['files' => true, 'route' => 'admin.urlshot.process']) !!}
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="screen-container">
            <div class="col-md-10">
                <div class="form-group url-group">
                    {!! Form::label('urls', 'Урл:') !!}
                    <div class="add-url-container" >
                        {!! Form::input('url','url', null, ['class' => 'form-control']) !!}
                        <button type="button" class="btn-mini button-add-value" ><i class="fa fa-plus" aria-hidden="true"></i></button> &nbsp;
                        <button type="button" class="btn-mini button-remove-value" style="display:none"><i class="fa fa-minus" aria-hidden="true"></i></button>
                        <div class="preloader" style="display: none"><img height="65%" src="/img/ajax-loader.gif" alt=""></div>
                        <div class ="links" style="visibility:hidden">
                            <a href ="#" class="show_direct" target="_blank">Посмотреть|</a> 
                            <a href ="#" class="show_media"  target="_blank">Открыть в медиабиблиотеке|</a>
                            <a href ="#" class="download" target="_blank" download>Скачать|</a>
                        </div>
                    </div>
                </div>
                
                <div class="settings">
                    <div class="form-group">
                        <h4> {!! 'Расширение' !!} </h4>
                        <div class="radio abc-radio">
                            {!! Form::radio('extension', 'png', true) !!}
                            {!! Form::label('extension', 'png') !!}
                        </div>
                        <div class="radio abc-radio">
                            {!! Form::radio('extension', 'jpg', false) !!}
                            {!! Form::label('extension', 'jpg') !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <h4> Размер </h4>
                        <div class="radio abc-radio">
                            {!! Form::radio('size', 'allPage', true) !!}
                            {!! Form::label('size', 'Вся страница') !!}
                        </div>
                        <div class="radio abc-radio">
                            {!! Form::radio('size', 'fixed', false) !!}
                            {!! Form::label('size', 'Размер') !!}
                            <div class="form-group page-size">
                                {!! Form::text('pageSizeX', null, ['class' => 'form-control page-size-input']) !!} х  {!! Form::text('pageSizeY', null, ['class' => 'form-control page-size-input']) !!}px

                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <h4> Время </h4>

                        <div class="radio abc-radio">
                            {!! Form::radio('time', 'immediately', true) !!}
                            {!! Form::label('time', 'Сразу') !!}
                        </div>
                        <div class="radio abc-radio">
                            {!! Form::radio('time', 'in_delay', false) !!}
                            {!! Form::label('time', 'С задержкой') !!}
                            <div class="form-group page-size">
                                {!! Form::text('delay_time', null, ['class' => 'form-control size-input-little']) !!}
                                <span class="delay_seconds"> Секунд </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" style="display: inline-flex">
                        <h4> Качество </h4>
                        {!! Form::input('number', 'quality', 80, ['class' => 'form-control size-input-little']) !!}<span class="quality-percent">% </span>
                    </div>
                    
                </div>
                <br>
                {!! Form::submit('Выполнить', ['class' => 'btn btn-primary']) !!}
            </div>
        </div>

    {!! Form::close() !!}
        </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/js/bootstrap.js"> </script>
    <script>  
        var $form = $('form');
        $(document).on('click', '.button-add-value', function (e) {
            e.preventDefault();
            var $container = $(this).parent().clone();
            $container.find('.links').css('visibility', 'hidden');
            $container.find("input").val("");
            $container.appendTo(".url-group");

            var $removeButtons = $('.button-remove-value');
            if ($removeButtons.length !== 1) {
                $removeButtons.show();
            }
        });

        $(document).on('click', '.button-remove-value', function (e) {
            e.preventDefault();
            $(this).parent().remove();

            var $removeButtons = $('.button-remove-value');
            if ($removeButtons.length === 1) {
                $removeButtons.hide();
            }
        });

        $form.on('submit', function (e) {
           e.preventDefault();
           var $urls = $('.add-url-container');
           var $settings = $('.settings :input');
            
            $urls.each(function (e) {
                var $this = $(this);
                $this.find('.preloader').show();
                $this.find('.links').css('visibility', 'hidden');
                $.ajax({
                    'type': 'POST',
                    'data': $(this).find('input').serialize() + '&' + $settings.serialize(),
                    'url': $form.attr('action'),
                    success: function (data) {
                        $this.find('.preloader').hide();
                        $this.find('.show_direct').attr('href', '/'  + data);
                        $this.find('.download').attr('href', '/'  + data);
                        $this.find('.links').css('visibility', 'visible');
                    }
                });
            });
           

        });



    </script>
    </body>
</html>
