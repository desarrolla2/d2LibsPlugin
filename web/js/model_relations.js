var Radmas = {
    PermissionManagerObserver: {
        items: [],
        add: function($element){
            this.items.push($element);
        },
        update: function(){
            for (i = 0; i < this.items.length; i++) {
                this.items[i].loadPermissions();
            }
        }
    },
    PermissionManager: function(parameters) {

        this.parameters = parameters;

        this.relations_list_url = '/model_relations/listRelations.json';
        this.add_request_url = '/model_relations/addRelation.json';
        this.del_request_url = '/model_relations/removeRelation.json';
        this.target_elements_url = '/model_relations/listTargetElements.json';
        this.block = $('div#'+this.parameters['component_id']);
        this.searchElements = [];

        this.initialize =
        function(){
            Radmas.PermissionManagerObserver.add(this);

            $.ajax(
            {
                url: this.target_elements_url,
                type: 'POST',
                dataType: "json",
                context: this,
                data: ({
                    to_class: parameters['to_class']
                }),
                success: function (data, status){

                    this.searchElements = data;
                    var searchStrings = [];

                    for ( var name in data ){
                        searchStrings.push(name);
                    }
        
                    $(this.block).find('input').autocomplete( searchStrings );

                    $(this.block).find('input').bind('keyup mouseup', {
                        context: this
                    }, function(event){
                        var context = event.data.context;
                        var item = $(context.block).find('input').val();
                        if( context.searchElements[item] != null ){
                            $(context.block).find('input').val('');
                            var target_id = context.searchElements[item];
                            context.addRelation(target_id);
                        }
                        return false;
                    });        
                },
                error: function (data, status, e){
                    // alert('Ocurrió un error cargando los datos solicitados:.\n'+data.error);
                }
            });

            this.loadPermissions();
        }
        
        this.loadPermissions = function(){
            $.ajax(
            {
                url: this.relations_list_url,
                type: 'POST',
                data: ({
                    relation_class: parameters['relation_class'],
                    from_class: parameters['from_class'],
                    from_id: parameters['from_id'],
                    to_class: parameters['to_class'],
                    permission_class: parameters['permission_class'],
                    permission_id: parameters['permission_id']
                }),
                dataType: "json",
                context: this,
                success: function (data, status){
                    $(this.block).find('ul').html('');

                    for (k = 0; k < data.length; k++) {
                        this.printRelation(data[k]);
                    }
                },
                error: function (data, status, e){
                    // alert('Ocurrió un error cargando los datos solicitados:.\n'+data.error);
                }
            });
        }

        this.addRelation =
        function (target_id){
            $.ajax(
            {
                url: this.add_request_url,
                type: 'POST',
                data: ({

                    relation_class: parameters['relation_class'],
                    from_class: parameters['from_class'],
                    from_id: parameters['from_id'],
                    to_id: target_id,
                    to_class: parameters['to_class'],
                    permission_class: parameters['permission_class'],
                    permission_id: parameters['permission_id']

                }),
                dataType: "json",
                context: this,
                beforeSend: function(){
                    $(this.block).append('<span id="cargando_datos"> Cargando datos...</span>');
                },
                complete: function(){
                    $(this.block).find("#cargando_datos").hide();
                },
                success: function (data, status){
                    this.printRelation(data);
                    Radmas.PermissionManagerObserver.update();
                },
                error: function (data, status, e){
                    // alert('Ocurrió un error cargando los datos solicitados:.\n'+data.error);
                }
            });
        }

        this.printRelation =
        function (relation){
            if( relation.relation_id ){
                $("<a/>").attr('class', 'delete')
                .bind('click', {
                    relation_id: relation.relation_id,
                    context: this
                },
                function(event){
                    $(this).parent().remove();
                    var context = event.data.context;
                    $.ajax(
                    {
                        url: context.del_request_url,
                        type: 'POST',
                        data: ({
                            relation_id: event.data.relation_id,
                            relation_class: context.parameters['relation_class']
                        }),
                        dataType: "json",
                        context: context,
                        error: function (data, status, e){
                            // alert('Ocurrió un error cargando los datos solicitados:.\n'+data.error);
                        }
                    });
                }
                )
                .appendTo(
                    $("<li/>").attr("id", relation.relation_id)
                    .html( relation.to_name )
                    .appendTo( $(this.block).find('ul'))
                    );
            }
        }
    }
};

