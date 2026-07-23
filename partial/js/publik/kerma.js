$(document).ready(function(){
    // $('.select2').each(function(index, element) {
    //     var initValue = element.dataset.value != undefined ? element.dataset.value : false;
    //     var item = $(element);
    //     if (item.data('url')) {
    //         CustomInitSelect2(item, {
    //             url: item.data('url'),
    //             initialValue: initValue,
    //         }, myModalEl);
    //     } else {
    //         item.select2();
    //     }
    // });
    kolom = [
        {
            data: "id",
            orderable: false,
            searchable: false,
            render: function (data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
            }
        },
        { data: "referensi" },
        { data: "judul" },
        { data: "nm_unit" },
        { data: "mitra" },
        // { data: "tanggal_selesai" },
        { 
            data: "tanggal_selesai",
            orderable: false,
            searchable: false,
            render: function (data, type, row, meta) {
                var akhir = new Date(data);
                var today = new Date();
                if(today <= akhir){
                    result = '<span class="badge bg-primary">AKTIF</span>';
                }else{
                    result = '<span class="badge bg-danger">TIDAK AKTIF</span>';
                }
                return result;
            } 
        },
    ];
    kolom_def = [
        {
            targets: 6,
            data: "dokumen",
            render: function(data){
                button = ' - ';
                if(data != ''){
                    // button = `<button class="btn btn-sm btn-success download-dokumen" data-file"${data}">
                    // <i class="fa fa-file-download"></i> Download</button>`;
                    button = `<a class="btn btn-sm btn-success download-dokumen" href="${site}/uploads/kerma/${data}">
                    <i class="fa fa-file-download"></i> Download</a>`;
                }
                return button;
            }
        },
    ];
    default_table_init('kerma', 'publik/data_kerma', kolom, kolom_def);
});

function test(date)
{
    var akhir = new Date(date);
    var today = new Date();
    var d = new Date();
    d.setMonth(d.getMonth() - 6);
    if(akhir <= today){
        console.log('belum merah');
        if(akhir < d){
            console.log('aktif');
        }else{
            console.log('kuning');
        }
    }else{
        console.log('merah');
    }
}