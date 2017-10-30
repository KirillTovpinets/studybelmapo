declare var jquery: any;
declare var $: any;

export class Preloader{
     start(element): void {
        var $preloader = $("<div id='jpreloader' class='preloader-overlay'><div class='loader' style='text-align: center;position:absolute;left:50%;top:50%;margin-left:-24px;margin-top:-24px;'><img src='img/preloader.gif'/> <br/>Идёт загрузка...</div></div>");
        $preloader.css({
            'background-color': 'transparent',
            'width': '100%',
            'height': '100%',
            'left': '0',
            'top': '0',
            'z-index': '100',
            'position': 'absolute'
        });
        $(element).append($preloader);
    }

    stop(element): void {
        $(element).find('.preloader-overlay').remove();
    }
}