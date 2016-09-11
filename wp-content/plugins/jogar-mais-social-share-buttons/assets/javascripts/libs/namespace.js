;(function(context) {

    'use strict';

    var JOGARMAIS = function(namespace, callback) {
        var parts  = namespace.split( '\.' )
          , loader = JOGARMAIS.instantiate()
          , parent = context
          , count  = parts.length
          , index  = 0
        ;

        for ( index; index < count; index++ ) {
          parent[parts[index]] = ( count - 1 === index ) ? loader : parent[parts[index]] || {};
          parent               = parent[parts[index]];
        }

        if ( 'function' === typeof callback ) {
          callback.call( null, parent, jQuery );
        }

        return parent;
  };

  JOGARMAIS.instantiate = function() {
    var Instantiate       = function() {}
      , ObjectConstructor = function() {
          var instance;

          instance = new Instantiate();
          instance.start.apply( instance, arguments );

          return instance;
      }
    ;

    Instantiate.prototype             = ObjectConstructor.prototype;
    ObjectConstructor.prototype.start = function() {};

    return ObjectConstructor;
  };

 context.JOGARMAIS = JOGARMAIS;

})( window );