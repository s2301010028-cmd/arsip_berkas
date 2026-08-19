/* =========================================================
   ARSIP DIGITAL NOTICE
   FRONTEND + LOCAL STORAGE
========================================================= */

const STORAGE_KEY = "digital_archive_notice";


window.globalArsipData = [];

function getArsipData() {
    return window.globalArsipData;
}

/* =========================================================
   INIT
========================================================= */

document.addEventListener("DOMContentLoaded", async function () {
    const container = document.getElementById("hasilArsip");
    if(container) {
        container.innerHTML = `<div class="hasil-empty text-center py-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <h3 class="mt-3">Memuat Data...</h3>
        </div>`;
    }

    try {
        const response = await fetch('/api/notices');
        if(!response.ok) throw new Error("Gagal mengambil data");
        window.globalArsipData = await response.json();
    } catch(e) {
        console.error(e);
        showToast("Gagal memuat data dari server.");
        window.globalArsipData = [];
    }

    const tanggal = document.getElementById("filterTanggal");
    if (tanggal) {
        tanggal.value = new Date().toISOString().split("T")[0];
    }

    if (window.initialSearch) {
        const searchInput = document.getElementById("searchArsip");
        if(searchInput) {
            searchInput.value = window.initialSearch;
        }
    }

    tampilkanArsip();
    updateStatistics();
    renderMonthly();
});


/* =========================================================
   TAMPILKAN ARSIP
========================================================= */

window.currentPage = 1;
window.itemsPerPage = 20;

window.tampilkanArsip = function () {
    const data = getArsipData();

    const searchInput = document.getElementById("searchArsip");
    const keyword = searchInput ? searchInput.value.toLowerCase() : "";

    let hasil = data;

    if (keyword) {
        hasil = data.filter(item => {
            return (
                (item.lokasi && item.lokasi.toLowerCase().includes(keyword)) ||
                (item.petugas && item.petugas.toLowerCase().includes(keyword)) ||
                (item.status && item.status.toLowerCase().includes(keyword)) ||
                (item.tanggal && item.tanggal.includes(keyword)) ||
                (item.keterangan && item.keterangan.toLowerCase().includes(keyword)) ||
                (item.awal && String(item.awal).includes(keyword)) ||
                (item.akhir && String(item.akhir).includes(keyword))
            );
        });
    }

    renderHasil(hasil, keyword);
};

window.gantiHalaman = function(page) {
    window.currentPage = page;
    window.tampilkanArsip();
}

function renderHasil(data, keyword = "") {
    const container = document.getElementById("hasilArsip");

    if (!data.length) {
        container.innerHTML = `
            <div class="hasil-empty text-center py-5">
                <i class="bi bi-folder-x fs-1 text-muted mb-3 d-block"></i>
                <h3 class="fw-bold">Arsip Tidak Ditemukan</h3>
                <p class="text-muted">Belum ada arsip yang cocok dengan pencarian <strong>${escapeHtml(keyword)}</strong>.</p>
            </div>
        `;
        return;
    }

    const totalItems = data.length;
    const totalPages = Math.ceil(totalItems / window.itemsPerPage);
    
    // Ensure current page is valid
    if (window.currentPage > totalPages) window.currentPage = totalPages;
    if (window.currentPage < 1) window.currentPage = 1;

    const startIndex = (window.currentPage - 1) * window.itemsPerPage;
    const endIndex = startIndex + window.itemsPerPage;
    const paginatedData = data.slice(startIndex, endIndex);

    const totalNotice = data.reduce((total, item) => total + Number(item.jumlah || 0), 0);

    let rows = "";
    paginatedData.forEach(function (item) {
        rows += `
            <tr>
                <td>
                    <div class="nomor-cell">
                        <strong>${escapeHtml(item.awal)}</strong>
                        <small>s/d ${escapeHtml(item.akhir)}</small>
                    </div>
                </td>
                <td>${escapeHtml(item.shift)}</td>
                <td>${escapeHtml(item.petugas)}</td>
                <td><strong>${formatNumber(item.jumlah)}</strong></td>
                <td><span class="status ${statusClass(item.status)}">${escapeHtml(item.status)}</span></td>
                <td>
                    <div class="action-group">
                        <button type="button" class="action-button action-view" title="Lihat" onclick="lihatArsip('${item.id}')">
                            <i class="bi bi-eye"></i>
                        </button>
                        <button type="button" class="action-button action-edit" title="Edit" onclick="editArsip('${item.id}')">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <button type="button" class="action-button action-delete" title="Hapus" onclick="hapusArsip('${item.id}')">
                            <i class="bi bi-trash3"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
    });

    let paginationHTML = "";
    if (totalPages > 1) {
        paginationHTML = `<nav aria-label="Page navigation" class="mt-4"><ul class="pagination justify-content-center">`;
        
        // Prev button
        paginationHTML += `<li class="page-item ${window.currentPage === 1 ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="event.preventDefault(); gantiHalaman(${window.currentPage - 1})">Sebelumnya</a>
        </li>`;

        // Page numbers
        for (let i = 1; i <= totalPages; i++) {
            // Show only first, last, current, and adjacent pages
            if (i === 1 || i === totalPages || (i >= window.currentPage - 1 && i <= window.currentPage + 1)) {
                paginationHTML += `<li class="page-item ${window.currentPage === i ? 'active' : ''}">
                    <a class="page-link" href="#" onclick="event.preventDefault(); gantiHalaman(${i})">${i}</a>
                </li>`;
            } else if (i === window.currentPage - 2 || i === window.currentPage + 2) {
                paginationHTML += `<li class="page-item disabled"><a class="page-link" href="#">...</a></li>`;
            }
        }

        // Next button
        paginationHTML += `<li class="page-item ${window.currentPage === totalPages ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="event.preventDefault(); gantiHalaman(${window.currentPage + 1})">Berikutnya</a>
        </li>`;
        
        paginationHTML += `</ul></nav>`;
    }

    const titleText = keyword ? `Hasil Pencarian: "${escapeHtml(keyword)}"` : `Daftar Semua Arsip`;

    container.innerHTML = `
        <div class="hasil-card">
            <div class="hasil-card-header">
                <div class="hasil-info">
                    <div class="hasil-info-icon"><i class="bi bi-folder2-open"></i></div>
                    <div>
                        <h3>${titleText}</h3>
                        <p><i class="bi bi-table"></i> Menampilkan ${paginatedData.length} dari total ${totalItems} baris data</p>
                    </div>
                </div>
                <div class="hasil-summary">
                    <span class="summary-pill">${formatNumber(totalNotice)} Notice Keseluruhan</span>
                </div>
            </div>
            <div class="archive-table-wrap">
                <table class="archive-table table-hover">
                    <thead>
                        <tr>
                            <th>Nomor Notice</th>
                            <th>Shift</th>
                            <th>Petugas</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${rows}
                    </tbody>
                </table>
            </div>
            ${paginationHTML}
        </div>
    `;
}


/* =========================================================
   DETAIL
========================================================= */

window.lihatArsip = function (id) {

    const data =
        getArsipData();


    const item =
        data.find(
            function (item) {

                return item.id === id;

            }
        );


    if (!item) {

        return;

    }


    document.getElementById("detailJudul")
        .textContent =
        `Arsip ${item.lokasi}`;


    document.getElementById("detailTanggal")
        .textContent =
        formatDate(item.tanggal);


    document.getElementById("detailLokasi")
        .textContent =
        item.lokasi;


    document.getElementById("detailShift")
        .textContent =
        item.shift;


    document.getElementById("detailPetugas")
        .textContent =
        item.petugas;


    document.getElementById("detailNomor")
        .textContent =
        `${item.awal} s/d ${item.akhir}`;


    document.getElementById("detailJumlah")
        .textContent =
        `${formatNumber(item.jumlah)} Notice`;


    document.getElementById("detailKeterangan")
        .textContent =
        item.keterangan || "-";


    document.getElementById("detailStatus")
        .textContent =
        item.status;


    document.getElementById("modalDetail")
        .classList.add("show");


};


/* =========================================================
   EDIT
========================================================= */

window.editArsip = function (id) {
    const realId = String(id).split('_')[0];
    window.location.href = '/notice/' + realId + '/edit';
};


/* =========================================================
   DELETE
========================================================= */

window.hapusArsip = function (id) {
    const realId = String(id).split('_')[0];
    const yakin = confirm("Yakin ingin menghapus arsip ini (beserta seluruh shift di lokasi & tanggal yang sama)?");

    if (!yakin) {
        return;
    }

    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '/notice/' + realId;

    const csrfField = document.createElement('input');
    csrfField.type = 'hidden';
    csrfField.name = '_token';
    const metaCsrf = document.querySelector('meta[name="csrf-token"]');
    csrfField.value = metaCsrf ? metaCsrf.content : '';

    const methodField = document.createElement('input');
    methodField.type = 'hidden';
    methodField.name = '_method';
    methodField.value = 'DELETE';

    form.appendChild(csrfField);
    form.appendChild(methodField);
    document.body.appendChild(form);
    form.submit();
};


/* =========================================================
   MODAL
========================================================= */

window.closeModal = function () {

    document
        .getElementById("modalDetail")
        .classList.remove("show");

};


window.closeEditModal = function () {

    document
        .getElementById("modalEdit")
        .classList.remove("show");

};


/* =========================================================
   STATISTICS
========================================================= */

function updateStatistics() {

    const data =
        getArsipData();


    const hariIni =
        new Date()
            .toISOString()
            .split("T")[0];


    const jumlahHariIni =
        data.filter(
            function (item) {

                return item.tanggal === hariIni;

            }
        ).length;


    const totalNotice =
        data.reduce(
            function (total, item) {

                return total +
                    Number(item.jumlah || 0);

            },
            0
        );


    const pending =
        data.filter(
            function (item) {

                return item.status === "Pending";

            }
        ).length;


    document.getElementById("totalArsip")
        .textContent =
        formatNumber(data.length);


    document.getElementById("arsipHariIni")
        .textContent =
        formatNumber(jumlahHariIni);


    document.getElementById("totalNoticeArsip")
        .textContent =
        formatNumber(totalNotice);


    document.getElementById("totalPending")
        .textContent =
        formatNumber(pending);

}


/* =========================================================
   BULANAN
========================================================= */

function renderMonthly() {

    const container =
        document.getElementById("arsipBulanan");


    if (!container) {

        return;

    }


    const data =
        getArsipData();


    const months = {};


    data.forEach(
        function (item) {

            const month =
                item.tanggal.substring(0, 7);


            if (!months[month]) {

                months[month] = {

                    arsip: 0,

                    notice: 0

                };

            }


            months[month].arsip++;

            months[month].notice +=
                Number(item.jumlah || 0);

        }
    );


    const monthKeys =
        Object.keys(months)
            .sort()
            .reverse();


    if (!monthKeys.length) {

        container.innerHTML = `

            <div class="hasil-placeholder"
                 style="grid-column:1/-1;">

                <div class="placeholder-icon">

                    <i class="bi bi-calendar-x"></i>

                </div>

                <h3>
                    Belum ada arsip bulanan
                </h3>

                <p>
                    Arsip dari Input Notice akan muncul di sini.
                </p>

            </div>

        `;

        return;

    }


    container.innerHTML = "";


    monthKeys.forEach(
        function (month) {

            const item =
                months[month];


            container.innerHTML += `

                <div class="bulan-card">

                    <div class="bulan-top">

                        <div class="bulan-icon">

                            <i class="bi bi-calendar3"></i>

                        </div>

                        <i class="bi bi-arrow-right text-muted"></i>

                    </div>


                    <h3>
                        ${formatMonth(month)}
                    </h3>


                    <p>
                        Rekap arsip bulan
                    </p>


                    <div class="bulan-data">

                        <div>

                            <span>
                                Arsip
                            </span>

                            <strong>
                                ${formatNumber(item.arsip)}
                            </strong>

                        </div>


                        <div>

                            <span>
                                Notice
                            </span>

                            <strong>
                                ${formatNumber(item.notice)}
                            </strong>

                        </div>

                    </div>

                </div>

            `;

        }
    );

}


/* =========================================================
   EXPORT EXCEL
========================================================= */

window.exportExcel = function () {

    const data =
        getArsipData();


    if (!data.length) {

        showToast(
            "Belum ada data untuk diekspor."
        );

        return;

    }


    let table = `

        <table border="1">

            <tr>

                <th>No</th>

                <th>Tanggal</th>

                <th>Lokasi</th>

                <th>Shift</th>

                <th>Petugas</th>

                <th>Nomor Seri Awal</th>

                <th>Nomor Seri Akhir</th>

                <th>Jumlah</th>

                <th>Status</th>

                <th>Keterangan</th>

            </tr>

    `;


    data.forEach(
        function (item, index) {

            table += `

                <tr>

                    <td>
                        ${index + 1}
                    </td>

                    <td>
                        ${item.tanggal}
                    </td>

                    <td>
                        ${escapeHtml(item.lokasi)}
                    </td>

                    <td>
                        ${escapeHtml(item.shift)}
                    </td>

                    <td>
                        ${escapeHtml(item.petugas)}
                    </td>

                    <td>
                        ${escapeHtml(item.awal)}
                    </td>

                    <td>
                        ${escapeHtml(item.akhir)}
                    </td>

                    <td>
                        ${item.jumlah}
                    </td>

                    <td>
                        ${escapeHtml(item.status)}
                    </td>

                    <td>
                        ${escapeHtml(item.keterangan || "")}
                    </td>

                </tr>

            `;

        }
    );


    table += "</table>";


    const html = `

        <html>

        <head>

            <meta charset="UTF-8">

        </head>

        <body>

            <h2>Arsip Digital Notice</h2>

            ${table}

        </body>

        </html>

    `;


    const blob =
        new Blob(
            [html],
            {
                type:
                    "application/vnd.ms-excel"
            }
        );


    const url =
        URL.createObjectURL(blob);


    const link =
        document.createElement("a");


    link.href = url;


    link.download =
        "arsip-digital-notice.xls";


    document.body.appendChild(link);

    link.click();

    link.remove();


    URL.revokeObjectURL(url);


    showToast(
        "Data berhasil diekspor ke Excel."
    );

};


/* =========================================================
   RESET
========================================================= */

window.resetArsip = function () {

    document.getElementById("filterLokasi")
        .value = "";


    document.getElementById("filterTanggal")
        .value =
        new Date()
            .toISOString()
            .split("T")[0];


    document.getElementById("hasilArsip")
        .innerHTML = `

            <div class="hasil-placeholder">

                <div class="placeholder-icon">

                    <i class="bi bi-folder2"></i>

                </div>

                <h3>
                    Belum Ada Arsip Dipilih
                </h3>

                <p>
                    Silakan pilih tanggal dan lokasi terlebih dahulu.
                </p>

            </div>

        `;


    updateStatistics();

    renderMonthly();


    showToast(
        "Halaman arsip berhasil diperbarui."
    );

};


/* =========================================================
   FORMAT
========================================================= */

function formatNumber(number) {

    return Number(number || 0)
        .toLocaleString("id-ID");

}


function formatDate(dateString) {

    if (!dateString) {

        return "-";

    }


    const date =
        new Date(
            dateString + "T00:00:00"
        );


    return date.toLocaleDateString(
        "id-ID",
        {
            day: "2-digit",
            month: "long",
            year: "numeric"
        }
    );

}


function formatMonth(monthString) {

    const date =
        new Date(
            monthString + "-01T00:00:00"
        );


    return date.toLocaleDateString(
        "id-ID",
        {
            month: "long",
            year: "numeric"
        }
    );

}


function statusClass(status) {

    return String(status)
        .toLowerCase()
        .replace(/\s+/g, "-");

}


function escapeHtml(value) {

    return String(value ?? "")
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");

}


/* =========================================================
   TOAST
========================================================= */

function showToast(message) {

    const old =
        document.querySelector(
            ".arsip-toast"
        );


    if (old) {

        old.remove();

    }


    const toast =
        document.createElement("div");


    toast.className =
        "arsip-toast";


    toast.innerHTML = `

        <i class="bi bi-check-circle-fill"></i>

        ${escapeHtml(message)}

    `;


    document.body.appendChild(toast);


    setTimeout(
        function () {

            toast.remove();

        },
        2500
    );

}


/* =========================================================
   CLOSE MODAL WHEN CLICK OUTSIDE
========================================================= */

document.addEventListener(
    "click",
    function (event) {

        if (
            event.target.classList.contains(
                "arsip-modal"
            )
        ) {

            event.target.classList.remove(
                "show"
            );

        }

    }
);


/* =========================================================
   ESCAPE
========================================================= */

document.addEventListener(
    "keydown",
    function (event) {

        if (event.key === "Escape") {

            document
                .querySelectorAll(
                    ".arsip-modal.show"
                )
                .forEach(
                    function (modal) {

                        modal.classList.remove(
                            "show"
                        );

                    }
                );

        }

    }
);