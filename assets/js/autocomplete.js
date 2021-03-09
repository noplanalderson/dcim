    var base_url = window.location.origin + '/';
    var options = {
    url: base_url + "search/data_json",
    // url: 'http://localhost/search/data_json',

    getValue: "data",
    theme: "plate-dark",
      list: {
        showAnimation: {
          type: "slide", //normal|slide|fade
          time: 400,
          callback: function() {}
        },
        hideAnimation: {
          type: "fade", //normal|slide|fade
          time: 400,
          callback: function() {}
        },
        match: {
          enabled: true
        }
      }
    };

    $("#search").easyAutocomplete(options);
