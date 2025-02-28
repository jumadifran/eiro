<table id="daftar_pinjaman" data-options="
                   url:'<?php echo site_url('pinjaman/daftar_pinjaman/get') ?>',
                   method:'post',
                   border:true,
                   singleSelect:true,
                   fit:true,
                   pageSize:30,
                   rownumbers:true,
                   fitColumns:false,
                   remoteSort:true,
                   multiSort:true,
                   pagination:true,
                   showFooter:true,
                   toolbar:'#daftar_pinjaman_toolbar'">
                <thead>
                <thead data-options="frozen:true">
                    <tr>
                        <!-- <th field="id" hidden="true"></th> -->
                        <th field="id" halign="right" width="70" sortable="true">ID Pinjaman</th>
                        <th field="no_anggota" halign="right" width="70" sortable="true" formatter="format_nomor_anggota">No Anggota</th>
                        <th field="nama_anggota" halign="center" sortable="true">Nama</th>
                    </tr>
                </thead>
                <thead>
                    <tr>
                        <th field="parent_pinjaman_id" halign="right" width="70" sortable="true">Parent Pinjaman</th>
                        <th field="nama_jenis_pinjaman" halign="center" sortable="true">Jenis</th>
                        <th field="kode_perusahaan" halign="center" width="50" sortable="true">Perusahaan</th>
                        <th field="estimasi_tgl_gajian" halign="center" sortable="true">tgl Gajian</th>
                        <th field="no_kredit" halign="center" width="80" sortable="true">No Kredit</th>
                        <th field="tgl_pinjaman" halign="center" width="100" align="center" formatter="App.formatDateDDMMYYYY">Tgl Pinjaman</th>
                        <th field="status" halign="center" sortable="true" formatter="status_pinjaman">Status Lunas</th>
                        <th field="nama_cabang" halign="center" sortable="true">Cabang</th>
                        <th field="jumlah_angsuran_awal" halign="center" sortable="true">Angsuran Awal</th>

                    </tr>
                </thead>
            </table>