var a2lix_libJS = a2lix_libJS || {};

a2lix_libJS.collectionModule = (function() {
    var pub = {};

//  cfg = {
//      $collectionElt: null,
//      $collectionEntryAddTplElt: null
//  };
    pub.init = function(cfg)
    {
        var collectionIncr = cfg.$collectionElt.find('.collection-entry').length;

        // Links Add/Delete
        cfg.$collectionElt.on('click', 'a[data-collection]', function(evt) {
            evt.preventDefault();

            var $elt = $(this);
            switch ($elt.data('collection')) {
                case 'delete':
                    if (confirm('Are you sure ?')) {
                        $elt.parents('.collection-entry').remove();
                    }
                    break;
                case 'add':
                    var $newDiv = $(cfg.$collectionEntryAddTplElt.html().replace(/__name__/g, collectionIncr++));
                    $elt.before($newDiv);
                    break;
            }
        });
    }
    
    return pub;
})();