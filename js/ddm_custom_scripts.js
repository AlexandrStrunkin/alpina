window.DigitalData = function() {
    this.campaigns     = {};
    this.recomendation = {};
    this.cart          = {};
    this.page          = "";
    this.user          = "";
    this.version       = "1.1.2";
    this.website       = {};
    this.wishlist      = {};
    this.ajaxUrl       = "/ajax/DigitalData/index.php";
    this.changes       = {};
}

window.DigitalData.prototype.Init = function() {
    this.getUser();
    this.getCart();
    this.getWebSite();
    this.getWishlist();
    this.getCampaigns();
    this.getPage();
};

window.DigitalData.prototype.getUser = function() {
    $this = this;
    $.ajax({
        type: "POST",
        dataType: "json",
        url: this.ajaxUrl,
        async: false,
        data: {action: "getUser"},
        success: function(response) {
            if(response.success) {
                $this.user = response.user;
            }
        }
    });
};

window.DigitalData.prototype.getPage = function() {
    if(window.PageInfoForDDM !== 'undefined') {
        this.page = window.PageInfoForDDM;
    }
};

window.DigitalData.prototype.getWebSite = function() {
    if($(location).host == "www.alpinabook.ru") {
        this.website.environment = "production";
    } else {
        this.website.environment = "testing";
    }
    this.website.environment = "responsive";
};

window.DigitalData.prototype.getWishlist = function() {
};

window.DigitalData.prototype.getCart = function() {
    $this = this;
    $.ajax({
        type: "POST",
        dataType: "json",
        url: this.ajaxUrl,
        async: false,
        data: {action: "getCart", order: 0},
        success: function(response) {
            if(response.success) {
                $this.cart = response.cart;
                //$this.changes.cart = response.cart;
            }
        }
    });
};

window.DigitalData.prototype.getCampaigns = function() {
};


$(document).ready(function() {
    window.DigitalDataObject = new DigitalData();
    /*$("#getUser").on("click", function(e){
        window.DigitalDataObject.Init();
    })*/
});
