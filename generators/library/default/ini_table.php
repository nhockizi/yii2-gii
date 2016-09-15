'use strict';
var datatableHandle = {
    initTable: function initTable() {
        this.table = $(this.table_id).DataTable({
            "oLanguage": {
                "sLengthMenu": "Hiện _MENU_ mục",
                "sSearch": "Tìm kiếm:",
                "oPaginate": {
                    "sPrevious": "Trước",
                    "sNext": "Kế tiếp"
                },
                "sEmptyTable": "Không có dữ liệu",
                "sProcessing": "Đang tải dữ liệu...",
                "sZeroRecords": "Không tìm thấy dữ liệu phù hợp",
                "sInfo": "Hiển thị _START_ đến _END_ của _TOTAL_ mục",
                "sInfoEmpty": "Hiển thị 0 đến 0 của 0 mục",
                "sInfoFiltered": "(filtered của _MAX_ tồng số trong mục)",
                "sInfoPostFix": "",
                "sUrl": ""
            },
            "aaSorting":this.aaSorting,
            "bSort":this.bSort,
            "columnDefs": this.columnDefs,
            scrollCollapse: true,
            "processing": true,
            "serverSide": true,
            "ajax": $.fn.dataTable.pipeline({
                url: this.url_index,
                pages: 5,
                data:'',
                table_id:this.table_id
            }),
            scrollX:        "200px",
            scrollY:        true,
            scrollCollapse: true,
            fixedColumns: this.fixedColumns,
            'info': this.info,
            'searching': this.searching,
            'lengthChange': this.lengthChange
        });
    },
    refresh: function refresh() {
        this.unChooseAll();
        this.table.clearPipeline().draw(false);
    },
    create: function view(self) {
        if(this.modal != 'page'){
            var id = '';
            this.modal = $(this.modal);
            generalIndex.modal(id, this.url_create,this.modal,'');
        }else{
            location.href = this.url_create;
        }
    },
    view: function view(self) {
        var id = $(self.target).data('id');
        if (self.target.nodeName === 'I') {
            id = $(self.target).parent().data('id');
        }
        if(this.modal != 'page'){
            this.modal = $(this.modal);
            generalIndex.modal(id, this.url_view,this.modal,'');
        }else{
            location.href = this.url_view + '/' + id;
        }
    },
    update: function view(self) {
        var id = $(self.target).data('id');
        if (self.target.nodeName === 'I') {
            id = $(self.target).parent().data('id');
        }
        if(this.modal != 'page'){
            this.modal = $(this.modal);
            generalIndex.modal(id, this.url_update,this.modal,'');
        }else{
            location.href = this.url_update + '/' + id;
        }
    },
    checkDelete: function checkDelete(self) {
        var id = $(self.target).data('id');
        this.modalDelete = $(this.modalDelete);
        if (self.target.nodeName === 'I') {
            id = $(self.target).parent().data('id');
        }
        var message = '';
        if(id == -1){
            message = 'Bạn có chắc muốn xóa tất cả dữ liệu không?';
        }else if(id == 0){
            message = 'Bạn có chắc muốn xóa dữ liệu đã chọn không?';
        }else{
            message = 'Bạn có chắc muốn xóa không?';
        }
        generalIndex.modal(id, this.url_check, this.modalDelete,message);
    },
    deleteData: function deleteData(self) {
        var id = $(self.target).data('value');
        if(id == -1){
            generalIndex.delete(0, this.url_delete_all, this.modalDelete).then(function () {
                return datatableHandle.refresh();
            });
        }else if(id == 0){
            var list_id = '';
            var i = 0;
            $(this.table_id+' .cb_single').filter(function() {
                if($(this).is(':checked')){
                    i++;
                    if(i == 1){
                        list_id = $(this).data('value');
                    }else{
                        list_id = list_id+','+$(this).data('value');
                    }
                }
            })
            if(list_id != ''){
                generalIndex.delete(list_id, this.url_delete_all, this.modalDelete).then(function () {
                    return datatableHandle.refresh();
                });
            }else{
                this.modalDelete.modal("hide")();
                return datatableHandle.refresh();
            }
        }else{
            this.modalDelete = $(this.modalDelete);
            generalIndex.delete(id, this.url_delete, this.modalDelete).then(function () {
                return datatableHandle.refresh();
            });
        }
    },
    tooggleChoose: function tooggleChoose() {
        if ($(this.table_id+" .cb_all").is(':checked')) {
            this.chooseAll();
            if(!$(this.table_id+'_wrapper div #btn-add').parent().hasClass('checked')){
                this.addDelete();
            }
        } else {
            this.unChooseAll();
        }
    },
    tooggleSingle : function tooggleSingle(){
        if($(this.table_id+'_wrapper div #btn-add').parent().hasClass('checked')){
            this.removeDelete();
        }else{
            this.addDelete();
        }
        var i = 0;
        $(this.table_id+' .cb_single').filter(function() {
            if($(this).is(':checked')){
                i++;
            }
        })
        if(i > 0){
            $(".cb_all").prop('checked', '');
        }
    },
    addCreate:function addCreate(){
        var html_data = '<div class="form-group">'+this.btn_more.create+'</div>';
        $(".form-btn").append(html_data);
    },
    addDelete:function addDelete(){
        // $(this.table_id+'_wrapper div #btn-add').parent().addClass('checked');
        // $(this.btn_more.delete_all).insertAfter(this.table_id+'_wrapper div #btn-add');
    },
    removeDelete:function removeDelete(){
        var i = 0;
        $(this.table_id+' .cb_single').filter(function() {
            if($(this).is(':checked')){
                i++;
            }
        })
        if(i == 0){
            $(this.table_id+'_wrapper div #btn-add').parent().removeClass('checked');
            $(this.table_id+'_wrapper div #btn-add').parent().html(this.btn_more.create);
        }
    },
    chooseAll: function chooseAll() {
        $(".cb_single").prop('checked', 'checked');
    },
    unChooseAll: function unChooseAll() {
        $(".cb_single").prop('checked', '');
        $(".cb_all").prop('checked', '');
        this.removeDelete();
    },
    searchData: function searchData() {
        var data = {};
        $(this.search+' .search-data').filter(function() {
            var name = $(this).data('search');
            data[name] = $(this).val(); 
        })
        $(this.table_id+'_wrapper #data_search_table').val(JSON.stringify(data));
        return datatableHandle.refresh();
    },
    bindEvents: function bindEvents() {
        this.table.on('click', '.btn-view', this.view.bind(this));
        this.table.on('click', '.btn-update', this.update.bind(this));
        this.table.on('click', '.btn-delete', this.checkDelete.bind(this));
        this.table.on('click', '.cb_all', this.tooggleChoose.bind(this));
        this.table.on('click', '.cb_single', this.tooggleSingle.bind(this));
        this.body.on('click', this.search+' #btn-search-table', this.searchData.bind(this));
        this.body.on('click', '#btn-delete-data', this.deleteData.bind(this));
        this.body.on('click', this.table_id+'_wrapper #btn-add', this.create.bind(this));
        this.body.on('click', this.table_id+'_wrapper .btn-delete-choose', this.checkDelete.bind(this));
        this.body.on('click', this.table_id+'_wrapper #btn-delete-all', this.checkDelete.bind(this));
    },
    init: function init(urls,data){
        this.table_id = urls.table_id;
        this.btn_more = urls.btn_more;
        this.url_index = urls.index;
        this.url_view = urls.view;
        this.url_create = urls.create;
        this.url_update = urls.update;
        this.url_delete = urls.delete;
        this.url_delete_all = urls.delete_all;
        this.url_check = urls.check;
        this.modal = urls.modal;
        this.search = urls.search;
        this.bSort = urls.bSort;
        this.aaSorting = urls.aaSorting;
        this.columnDefs = urls.columnDefs;
        this.body = $('body');
        this.modalDelete = "#modal-3";
        this.fixedColumns = urls.fixedColumns;
        this.info = urls.info;
        this.searching = urls.searching;
        this.lengthChange = urls.lengthChange;
        this.initTable();
        this.bindEvents();
        var form_btn = '<div class="form-group form-btn"></div>';
        $(form_btn).insertBefore("#table_product_wrapper");
        this.addCreate();
    }
};