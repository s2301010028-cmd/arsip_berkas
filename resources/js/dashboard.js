/* =========================================================
   DASHBOARD NOTICE PAJAK
   DATA DARI LOCAL STORAGE
========================================================= */

const DASHBOARD_STORAGE_KEY = "digital_archive_notice";


/* =========================================================
   GET DATA
========================================================= */

window.globalDashboardData = [];

function getDashboardData() {
    return window.globalDashboardData;
}

document.addEventListener("DOMContentLoaded", async function () {
    updateDashboardDate();
    
    try {
        const response = await fetch('/api/notices');
        if(!response.ok) throw new Error("Gagal");
        window.globalDashboardData = await response.json();
    } catch(e) {
        console.error(e);
        window.globalDashboardData = [];
    }
    
    updateDashboard();
});


/* =========================================================
   UPDATE DASHBOARD
========================================================= */

function updateDashboard() {

    const data = getDashboardData();


    const today =
        new Date()
            .toISOString()
            .split("T")[0];


    /* =====================================================
       TOTAL NOTICE
    ====================================================== */

    const totalNotice =
        data.reduce(
            function (total, item) {

                return total +
                    Number(item.jumlah || 0);

            },
            0
        );


    /* =====================================================
       NOTICE HARI INI
    ====================================================== */

    const dataHariIni =
        data.filter(
            function (item) {

                return item.tanggal === today;

            }
        );


    const noticeHariIni =
        dataHariIni.reduce(
            function (total, item) {

                return total +
                    Number(item.jumlah || 0);

            },
            0
        );


    /* =====================================================
       STATUS
    ====================================================== */

    const selesai =
        data.filter(
            function (item) {

                return (
                    item.status === "Selesai" ||
                    item.status === "Sesuai"
                );

            }
        );


    const pending =
        data.filter(
            function (item) {

                return item.status === "Pending";

            }
        );


    const rusak =
        data.filter(
            function (item) {

                return item.status === "Rusak";

            }
        );


    const batal =
        data.filter(
            function (item) {

                return item.status === "Batal";

            }
        );


    /* =====================================================
       JUMLAH BERDASARKAN STATUS
    ====================================================== */

    const totalSelesai =
        selesai.reduce(
            function (total, item) {

                return total +
                    Number(item.jumlah || 0);

            },
            0
        );


    const totalPending =
        pending.reduce(
            function (total, item) {

                return total +
                    Number(item.jumlah || 0);

            },
            0
        );


    const totalRusak =
        rusak.reduce(
            function (total, item) {

                return total +
                    Number(item.jumlah || 0);

            },
            0
        );


    const totalBatal =
        batal.reduce(
            function (total, item) {

                return total +
                    Number(item.jumlah || 0);

            },
            0
        );


    /* =====================================================
       LOKASI AKTIF
    ====================================================== */

    const lokasi =
        new Set(
            data.map(
                function (item) {

                    return item.lokasi;

                }
            )
        );


    /* =====================================================
       UPDATE ELEMENT
    ====================================================== */

    setText(
        "dashboardTotalNotice",
        formatNumber(totalNotice)
    );


    setText(
        "dashboardHariIni",
        formatNumber(noticeHariIni)
    );


    setText(
        "dashboardSelesai",
        formatNumber(totalSelesai)
    );


    setText(
        "dashboardPending",
        formatNumber(totalPending)
    );


    setText(
        "dashboardRusak",
        formatNumber(totalRusak)
    );


    setText(
        "dashboardBatal",
        formatNumber(totalBatal)
    );


    setText(
        "dashboardLokasi",
        formatNumber(lokasi.size)
    );


    setText(
        "dashboardArsip",
        formatNumber(data.length)
    );


    /* =====================================================
       TABEL HARI INI
    ====================================================== */

    renderTodayTable(
        dataHariIni
    );


    /* =====================================================
       RINGKASAN LOKASI
    ====================================================== */

    renderLocationSummary(
        data
    );

}


/* =========================================================
   TABEL NOTICE HARI INI
========================================================= */

function renderTodayTable(data) {

    const tbody =
        document.getElementById(
            "dashboardTodayTable"
        );


    if (!tbody) {
        return;
    }


    if (!data.length) {

        tbody.innerHTML = `

            <tr>

                <td
                    colspan="7"
                    class="dashboard-empty">

                    <div>

                        <i class="bi bi-inbox"></i>

                        <strong>
                            Belum ada notice hari ini
                        </strong>

                        <span>
                            Data dari Input Notice akan
                            muncul di sini.
                        </span>

                    </div>

                </td>

            </tr>

        `;

        return;

    }


    /* terbaru di atas */

    data =
        [...data].reverse();


    tbody.innerHTML = "";


    data.forEach(
        function (item, index) {

            tbody.innerHTML += `

                <tr>

                    <td>
                        ${index + 1}
                    </td>

                    <td>

                        <div class="dashboard-location">

                            <i class="bi bi-geo-alt"></i>

                            ${escapeHtml(item.lokasi)}

                        </div>

                    </td>

                    <td>

                        <span class="shift-badge ${

                            item.shift === "Pagi"

                                ? "shift-pagi"

                                : "shift-sore"

                        }">

                            ${escapeHtml(item.shift)}

                        </span>

                    </td>

                    <td>

                        <strong>
                            ${formatNumber(item.jumlah)}
                        </strong>

                    </td>

                    <td>

                        <span class="dashboard-status ${

                            getStatusClass(
                                item.status
                            )

                        }">

                            ${escapeHtml(item.status)}

                        </span>

                    </td>

                    <td>

                        ${escapeHtml(
                            item.petugas || "-"
                        )}

                    </td>

                    <td>

                        <button
                            type="button"
                            class="dashboard-view-btn"
                            onclick="openDashboardArchive(${item.id})">

                            <i class="bi bi-eye"></i>

                        </button>

                    </td>

                </tr>

            `;

        }
    );

}


/* =========================================================
   RINGKASAN LOKASI
========================================================= */

function renderLocationSummary(data) {

    const container =
        document.getElementById(
            "dashboardLocationSummary"
        );


    if (!container) {
        return;
    }


    const locations = {};


    data.forEach(
        function (item) {

            if (!locations[item.lokasi]) {

                locations[item.lokasi] = {

                    arsip: 0,

                    notice: 0

                };

            }


            locations[item.lokasi].arsip++;

            locations[item.lokasi].notice +=
                Number(item.jumlah || 0);

        }
    );


    const locationNames =
        Object.keys(locations)
            .sort();


    if (!locationNames.length) {

        container.innerHTML = `

            <div class="dashboard-location-empty">

                <i class="bi bi-geo-alt"></i>

                <p>
                    Belum ada data lokasi.
                </p>

            </div>

        `;

        return;

    }


    container.innerHTML = "";


    locationNames.forEach(
        function (name) {

            const item =
                locations[name];


            container.innerHTML += `

                <div class="location-summary-item">

                    <div class="location-summary-icon">

                        <i class="bi bi-geo-alt-fill"></i>

                    </div>

                    <div class="location-summary-info">

                        <strong>
                            ${escapeHtml(name)}
                        </strong>

                        <span>
                            ${item.arsip}
                            arsip
                        </span>

                    </div>

                    <div class="location-summary-total">

                        <strong>
                            ${formatNumber(item.notice)}
                        </strong>

                        <span>
                            Notice
                        </span>

                    </div>

                </div>

            `;

        }
    );

}


/* =========================================================
   BUKA ARSIP
========================================================= */

window.openDashboardArchive = function (id) {

    const data =
        getDashboardData();


    const item =
        data.find(
            function (item) {

                return item.id === id;

            }
        );


    if (!item) {
        return;
    }


    /*
     * Simpan filter agar halaman Arsip
     * langsung menampilkan data tersebut.
     */

    sessionStorage.setItem(
        "arsipTanggal",
        item.tanggal
    );


    sessionStorage.setItem(
        "arsipLokasi",
        item.lokasi
    );


    window.location.href =
        "/arsip";

};


/* =========================================================
   DATE
========================================================= */

function updateDashboardDate() {

    const element =
        document.getElementById(
            "dashboardDate"
        );


    if (!element) {
        return;
    }


    const today =
        new Date();


    element.textContent =
        today.toLocaleDateString(
            "id-ID",
            {
                weekday: "long",
                day: "numeric",
                month: "long",
                year: "numeric"
            }
        );

}


/* =========================================================
   HELPERS
========================================================= */

function setText(
    id,
    value
) {

    const element =
        document.getElementById(id);


    if (element) {

        element.textContent =
            value;

    }

}


function formatNumber(value) {

    return Number(value || 0)
        .toLocaleString("id-ID");

}


function getStatusClass(status) {

    return String(status || "")
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
   AUTO REFRESH
========================================================= */

window.addEventListener(
    "storage",
    function (event) {

        if (
            event.key ===
            DASHBOARD_STORAGE_KEY
        ) {

            updateDashboard();

        }

    }
);