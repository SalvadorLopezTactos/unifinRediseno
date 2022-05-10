/**
 * The file used to set js for rating
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */

// highlight stars of rating
function highlightStar(obj, que_id) {
	removeHighlight(que_id);
    $('#' + que_id + '_div li').each(function (index) {
        $(this).addClass('highlight');
        if (index == $('#' + que_id + '_div li').index(obj)) {
            return false;
        }
    });
}

// remove highlight
function removeHighlight(que_id) {

    $('#' + que_id + '_div li').removeClass('selected');
    $('#' + que_id + '_div li').removeClass('highlight');
}

//add rating bar to given div
function addRating(obj, que_id) {
    $('#' + que_id + '_div li').each(function (index) {
        $(this).addClass('selected');
        $('#' + que_id + '_hidden').val((index + 1));
        if (index == $('#' + que_id + '_div li').index(obj)) {
            return false;
        }
    });
    $("#" + que_id + '_hidden').val($('.highlight').length);
}

// reset rating
function resetRating(que_id) {
    if ($('#' + que_id + '_hidden').val() != 0) {
        $('#' + que_id + '_div li').each(function (index) {
            $(this).addClass('selected');
            if ((index + 1) == $("#" + que_id + '_hidden').val()) {
                return false;
            }
        });
    }
} 