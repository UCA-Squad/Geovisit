/* 
 * 
 * Observatoire de Physique du Globe de Clermont-Ferrand
 * Campus Universitaire des Cezeaux
 * 4 Avenue Blaise Pascal
 * TSA 60026 - CS 60026
 * 63178 AUBIERE CEDEX FRANCE
 * 
 * Author: Yannick Guehenneux
 *         y.guehenneux [at] opgc.fr
 * 
 */


$(document).ready(function () {

    var video = document.getElementById('atelier-video');
    var dialog = video.closest('.ui-dialog');
    

    var timeFormat = function (seconds) {
        var m = Math.floor(seconds / 60) < 10 ? '0' + Math.floor(seconds / 60) : Math.floor(seconds / 60);
        var s = Math.floor(seconds - (m * 60)) < 10 ? '0' + Math.floor(seconds - (m * 60)) : Math.floor(seconds - (m * 60));
        return m + ':' + s;
    };
    
    function runWhenLoaded() {
        $('.current').text(timeFormat(0));
        $('.duration').text(timeFormat(video.duration));

        $('.videoContainer').hover(function () {
            $('.control').stop().animate({'bottom': 0}, 500);
        }, function () {
            if (!timeDrag) {
                $('.control').stop().animate({'bottom': -45}, 500);
            }
        });
    }
    
    if (!video.readyState) {
        video.onloadedmetadata = function() {
            setTimeout(startBuffer, 150);
            runWhenLoaded();
        };
    } else {
        runWhenLoaded();
    }

    $('.control').show().css({'bottom': -45});
    

    var startBuffer = function () {
        var currentBuffer = video.buffered.end(0);
        var maxduration = video.duration;
        var perc = 100 * currentBuffer / maxduration;
        $('.bufferBar').css('width', perc + '%');

        if (currentBuffer < maxduration) {
            setTimeout(startBuffer, 500);
        }
    };

    $('#atelier-video').on('timeupdate', function () {
        var currentPos = video.currentTime;
        var maxduration = video.duration;
        var perc = 100 * currentPos / maxduration;
        $('.timeBar').css('width', perc + '%');
        $('.current').text(timeFormat(currentPos));
    });

    $('.btnPlay').on('click', function () {
        if (video.paused || video.ended) {
            $('.videoContainer').find('.ripple').remove();
            $('.btnPlay').addClass('paused');
            video.play();
        } else {
            $('.btnPlay').removeClass('paused');
            video.pause();
        }
    });

    $('.btnx025').on('click', function () {
        changeSpeed(this, 0.25);
    });
    $('.btnx05').on('click', function () {
        changeSpeed(this, 0.5);
    });
    $('.btnx1').on('click', function () {
        changeSpeed(this, 1);
    });
    $('.btnx125').on('click', function () {
        changeSpeed(this, 1.25);
    });
    $('.btnx15').on('click', function () {
        changeSpeed(this, 1.5);
    });
    $('.btnx2').on('click', function () {
        changeSpeed(this, 2);
    });

    var changeSpeed = function (obj, spd) {
        $('.text').removeClass('selected');
        $(obj).addClass('selected');
        video.pause();
        video.playbackRate = spd;
        video.play();
    };

    $('.btnStop').on('click', function () {
        $('.videoContainer').find('.ripple').remove();
        $('.btnPlay').removeClass('paused');
        updatebar($('.progress').offset().left);
        video.pause();
    });
    
    var shiftScroll = false;

    $(document).keydown(function (e) {
        if (e.shiftKey) {
            shiftScroll = true;
        }
    });

    $(document).keyup(function (e) {
        if (e.which === 16) {
            shiftScroll = false;
        }
    });

    $(document).keypress(function (e) {
        if (e.which === 32 && $(dialog).is(':visible')) {
            e.preventDefault();
            if (video.paused || video.ended) {
                $('.btnPlay').addClass('paused');
                video.play();
            } else {
                $('.btnPlay').removeClass('paused');
                video.pause();
            }
        }
    });

    $('#atelier-video').on('ended', function () {
        $('.btnPlay').removeClass('paused');
        video.pause();
    });

    var timeDrag = false;
    $('.progress').on('mousedown', function (e) {
        timeDrag = true;
        updatebar(e.pageX);
    });

    $(document).on('mouseup', function (e) {
        if (timeDrag) {
            timeDrag = false;
            updatebar(e.pageX);
        }
    });

    $(document).on('mousemove', function (e) {
        if (timeDrag) {
            updatebar(e.pageX);
        }        
    });

    var updatebar = function (x) {
        var progress = $('.progress');

        var maxduration = video.duration;
        var position = x - progress.offset().left;
        var percentage = 100 * position / progress.width();

        if (percentage > 100) {
            percentage = 100;
        }

        if (percentage < 0) {
            percentage = 0;
        }

        $('.timeBar').css('width', percentage + '%');
        video.currentTime = maxduration * percentage / 100;
    };

    
});