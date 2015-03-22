/**
 * Created by gmorel on 27/03/15.
 */
$(function(){ // on dom ready

    $('#cy').cytoscape({
      layout: {
        name: 'breadthfirst',
        padding: 50,
          animate: true,
          animationDuration: 500,
          maximalAdjustments: 2,
          directed: false
      },

      style: cytoscape.stylesheet()
        .selector('node')
          .css({
            'shape': 'data(faveShape)',
            'width': 'mapData(weight, 40, 80, 20, 60)',
            'content': 'data(name)',
            'text-valign': 'center',
            'text-outline-width': 2,
            'text-outline-color': 'data(faveColor)',
            'background-color': 'data(faveColor)',
            'color': '#fff'
          })
        .selector(':selected')
          .css({
            'border-width': 3,
            'border-color': '#333'
          })
        .selector('edge')
          .css({
            'opacity': 0.666,
            'width': 'mapData(strength, 70, 100, 2, 6)',
            'target-arrow-shape': 'triangle',
            'source-arrow-shape': 'circle',
            'line-color': 'data(faveColor)',
            'source-arrow-color': 'data(faveColor)',
            'target-arrow-color': 'data(faveColor)',
              'curve-style': 'bezier'
          })
        .selector('edge.questionable')
          .css({
            'line-style': 'dotted',
            'target-arrow-shape': 'diamond'
          })
        .selector('.faded')
          .css({
            'opacity': 0.25,
            'text-opacity': 0
          }),

      elements: dataWorkflow,

      ready: function(){
        window.cy = this;

    //   this.$('#i').renderedPosition({
    //  x: 0,
    //  y: 0
    //});

//          this.$('#i').animate({renderedPosition:
//          {x: 200, y: 200}
//          }, {
//  duration: 500
//});
    //
    //      var layout = this.elements().makeLayout({
    //  name: 'grid'
    //});
    //
    //layout.run();

    //      this.$('#c').position({
    //  x: 600,
    //  y: 200
    //});

        // giddy up
      }
    });

}); // on dom ready

