    $('select[name=mask]').on('change', function(){
        var self = this;
        $('select[name=submask]').find('option').prop('disabled', function(){
            return this.value && this.value < self.value && self.value
        });
        $('select[name=submask]').find('option').prop('selected', function(){
            return this.value && this.value > self.value && self.value
        });
    });
    function ip()
    {
      var a = document.getElementById("mask").value;
      var b = [0];
      var c = [0,128];
      var d = [0,64,128,192];
      var e = [0,32,64,96,128,160,192,224];
      var f = [0,16,32,48,64,80,96,112,128,144,160,176,192,208,224,240];
      var g = [0,8,16,24,32,40,48,56,64,72,80,88,96,104,112,120,128,136,144,152,160,168,176,184,192,200,208,216,224,232,240,248];
      var h = [0,4,8,12,16,20,24,28,32,36,40,44,48,52,56,60,64,68,72,76,80,84,88,92,96,100,104,108,112,116,120,124,128,132,136,140,144,148,152,156,160,164,168,172,176,180,184,188,192,196,200,204,208,212,216,220,224,228,232,236,240,244,248,252];

      if(a == "24")
      {
          var select = document.getElementById("4");
          select.innerHTML = "";
          
          for(var i = 0; i < b.length; i++) 
          {
              var opt = b[i];
              select.innerHTML += "<option value=\"" + opt + "\">" + opt + "</option>";
          }
      }
        else if(a == "25")
      {
          
          var select = document.getElementById("4");
          select.innerHTML = "";
          
          for(var i = 0; i < c.length; i++) 
          {
              var opt = c[i];
              select.innerHTML += "<option value=\"" + opt + "\">" + opt + "</option>";
          }
      }
        else if(a == "26")
      {

          var select = document.getElementById("4");
          select.innerHTML = "";
          
          for(var i = 0; i < d.length; i++) 
          {
              var opt = d[i];
              select.innerHTML += "<option value=\"" + opt + "\">" + opt + "</option>";
          }
      }
        else if(a == "27")
      {

          var select = document.getElementById("4");
          select.innerHTML = "";
          
          for(var i = 0; i < e.length; i++) 
          {
              var opt = e[i];
              select.innerHTML += "<option value=\"" + opt + "\">" + opt + "</option>";
          }
      }
        else if(a == "28")
      {

          var select = document.getElementById("4");
          select.innerHTML = "";
          
          for(var i = 0; i < f.length; i++) 
          {
              var opt = f[i];
              select.innerHTML += "<option value=\"" + opt + "\">" + opt + "</option>";
          }
      }
        else if(a == "29")
      {

          var select = document.getElementById("4");
          select.innerHTML = "";
          
          for(var i = 0; i < g.length; i++) 
          {
              var opt = g[i];
              select.innerHTML += "<option value=\"" + opt + "\">" + opt + "</option>";
          }
      }
        else if(a == "30")
      {

          var select = document.getElementById("4");
          select.innerHTML = "";
          
          for(var i = 0; i < h.length; i++) 
          {
              var opt = h[i];
              select.innerHTML += "<option value=\"" + opt + "\">" + opt + "</option>";
          }
      }

    }