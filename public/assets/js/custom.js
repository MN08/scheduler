/*
* @Author: donytri86
* @Date:   2020-05-07 13:04:56
* @Last Modified by:   donytri86
* @Last Modified time: 2020-08-22 12:30:45
*/

$(document).ready(function () {
    $('.course-topic-collapse').on('hide.bs.collapse', function () {
        $(this)
            .closest('.course-topic-detail')
            .find('button[data-toggle="collapse"] i')
            .removeClass('fa-angle-up')
            .addClass('fa-angle-down');
    });

    $('.course-topic-collapse').on('shown.bs.collapse', function () {
        $(this)
            .closest('.course-topic-detail')
            .find('button[data-toggle="collapse"] i')
            .removeClass('fa-angle-down')
            .addClass('fa-angle-up');
    });
});
