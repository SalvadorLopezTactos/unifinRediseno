({
     initialize: function (options) {
        this._super('initialize', [options]);
    },

    _render: function() {
        this._super('_render');

        this.showCounter();
    },

    showCounter: function(  ){
        contextCounter = this;
        var seconds = 0;
        var minutes = 0;
        var hours = 0;

        setInterval(function() {
            seconds++;

            if (seconds == 60) {
            seconds = 0;
            minutes++;
            }

            if (minutes == 60) {
            minutes = 0;
            hours++;
            }

            var formattedTime = contextCounter.pad(hours) + ':' + contextCounter.pad(minutes) + ':' + contextCounter.pad(seconds);
            $('#timer').html(formattedTime);
        }, 1000);
    },

    pad: function (number) {
        if (number < 10) {
            return '0' + number;
        }
        
        return number;
    }


})