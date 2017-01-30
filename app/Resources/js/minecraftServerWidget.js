/**
 * Created by olaf on 29.01.17.
 */
$.widget("minephp.minecraftServerPanel", {
    serverId: null,
    options: {
        dataRoute: 'app_ajax_queryserver'
    },
    _create: function () {
        var self = this;
        this.serverId = $(this.element).data('serverid');
        console.log(this.serverId);
        this._loadData();
        window.setInterval(function () {
            self._loadData()
        }, 60000);
    },
    _loadData: function () {
        var self = this;
        $.ajax({
            url: Routing.generate(self.options.dataRoute, {id: self.serverId}),
            type: "GET",
            context: self
        }).done(function (res) {
            this._updateDisplay(res.data);
        });
    },
    _updateDisplay: function (data) {
        console.log(data);
        $(this.element).find('[data-property=players_online]').html(data['players']['online']);
        if (data['favicon']) {
            $(this.element).find('[data-property=img]').html('<img class="img-rounded" src="' + data['favicon'] + '"/>')
        }

    }
});