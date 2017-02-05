/**
 * Created by olaf on 29.01.17.
 */
$.widget("minephp.minecraftServerPanel", {
    serverId: null,
    options: {
        dataRoute: 'app_ajax_queryserver',
        refreshInterval: 20000,
        userImageBaseUrl: "https://mc-heads.net/combo/",
        userImagePostfix: "/64.png"
    },
    _create: function () {
        var self = this;
        this.serverId = $(this.element).data('serverid');
        this._loadData();
        window.setInterval(function () {
            self._loadData()
        }, self.options.refreshInterval);
    },
    _loadData: function () {
        var self = this;
        $.ajax({
            url: Routing.generate(self.options.dataRoute, {id: self.serverId}),
            type: "GET",
            context: self
        }).done(function (res) {
            this._updateDisplay(res);
        });
    },
    _updateDisplay: function (res) {
        if (res.success) {
            var pingData = res.data.pingData;
            $(this.element).removeClass('panel-danger').addClass('panel-success');
            $(this.element).find('[data-property=players_online]').html(pingData.players.online);
            var playersString = "&nbsp;";
            if (pingData.players.sample) {
                var sampleData = pingData.players.sample;
                for (var i = 0; i < sampleData.length; i++) {
                    playersString += '<span class="badge">' + sampleData[i].name + '</span>';
                }
            }
            $(this.element).find('[data-property=sample]').html(playersString);

            if (pingData.favicon) {
                $(this.element).find('[data-property=img]').html('<img class="img-rounded" src="' + pingData.favicon + '"/>')
            }

            if (res.data.players) {
                var allPlayersList = "";

                for (var idx = 0; idx < res.data.players.length; idx++) {
                    allPlayersList += '<li>' +
                        '<img title="' + res.data.players[idx] + '" src="' + this.options.userImageBaseUrl + res.data.players[idx] + this.options.userImagePostfix + '"/>' +
                        '</li>';
                }
                console.log($(this.element).find('[data-property=players]'));
                $(this.element).find('[data-property=players]').html(allPlayersList);
            }
        }
        else {
            $(this.element).removeClass('panel-success').addClass('panel-danger');
        }
    }
});