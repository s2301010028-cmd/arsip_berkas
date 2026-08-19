/* =========================================================
   INPUT NOTICE
   FRONTEND + LOCAL STORAGE
========================================================= */


/* =========================================================
   STORAGE
========================================================= */

const NOTICE_STORAGE_KEY =
    "digital_archive_notice";


function getNoticeData() {

    const data =
        localStorage.getItem(
            NOTICE_STORAGE_KEY
        );


    if (!data) {

        return [];

    }


    try {

        return JSON.parse(data);

    } catch (error) {

        return [];

    }

}


function saveNoticeData(data) {

    localStorage.setItem(
        NOTICE_STORAGE_KEY,
        JSON.stringify(data)
    );

}


/* =========================================================
   FORMAT NOMOR
========================================================= */

function formatNotice(value) {

    value =
        value.replace(
            /\D/g,
            ""
        );


    value =
        value.substring(
            0,
            10
        );


    if (value.length > 2) {

        value =
            value.substring(0, 2)
            +
            "-"
            +
            value.substring(2);

    }


    return value;

}


function getNumber(value) {

    return (
        parseInt(
            String(value)
                .replace(/\D/g, "")
        )
        || 0
    );

}


/* =========================================================
   INIT
========================================================= */

document.addEventListener(
    "DOMContentLoaded",
    function () {

        const form =
            document.querySelector(
                "form"
            );


        const lokasi =
            document.getElementById(
                "lokasi"
            );


        const tanggal =
            document.querySelector(
                'input[type="date"]'
            );


        const cardPagi =
            document.getElementById(
                "cardPagi"
            );


        const cardSore =
            document.getElementById(
                "cardSore"
            );


        const previewLokasi =
            document.getElementById(
                "previewLokasi"
            );


        const progressBar =
            document.getElementById(
                "progressBar"
            );


        const totalNotice =
            document.getElementById(
                "totalNotice"
            );


        const awalPagi =
            document.getElementById(
                "awalPagi"
            );


        const akhirPagi =
            document.getElementById(
                "akhirPagi"
            );


        const jumlahPagi =
            document.getElementById(
                "jumlahPagi"
            );


        const awalSore =
            document.getElementById(
                "awalSore"
            );


        const akhirSore =
            document.getElementById(
                "akhirSore"
            );


        const jumlahSore =
            document.getElementById(
                "jumlahSore"
            );


        if (!form || !lokasi) {

            return;

        }


        /* =====================================================
           FORMAT NOMOR
        ====================================================== */

        document
            .querySelectorAll(
                ".notice-number"
            )
            .forEach(
                function (input) {

                    input.addEventListener(
                        "input",
                        function () {

                            this.value =
                                formatNotice(
                                    this.value
                                );

                        }
                    );

                }
            );


        /* =====================================================
           LOKASI
        ====================================================== */

        const lokasiSampling = [

            "Sampling 1",
            "Sampling 2",
            "Sampling 3",
            "Sampling 4",
            "Sampling 5",
            "Sampling 6"

        ];


        lokasi.addEventListener(
            "change",
            function () {

                if (previewLokasi) {

                    previewLokasi.textContent =
                        this.value || "-";

                }


                if (
                    lokasiSampling.includes(
                        this.value
                    )
                ) {

                    cardSore.style.display =
                        "block";

                } else {

                    cardSore.style.display =
                        "none";

                }


                hitungPagi();

                hitungSore();

                updateProgress();

            }
        );


        /* =====================================================
           HITUNG PAGI
        ====================================================== */

        function hitungPagi() {

            if (!awalPagi || !akhirPagi) {

                return;

            }


            const awal =
                getNumber(
                    awalPagi.value
                );


            const akhir =
                getNumber(
                    akhirPagi.value
                );


            if (
                awal > 0 &&
                akhir >= awal
            ) {

                jumlahPagi.value =
                    (akhir - awal) + 1;

            } else {

                jumlahPagi.value = "";

            }


            hitungTotal();

            updateProgress();

        }


        /* =====================================================
           HITUNG SORE
        ====================================================== */

        function hitungSore() {

            if (!awalSore || !akhirSore) {

                return;

            }


            const awal =
                getNumber(
                    awalSore.value
                );


            const akhir =
                getNumber(
                    akhirSore.value
                );


            if (
                awal > 0 &&
                akhir >= awal
            ) {

                jumlahSore.value =
                    (akhir - awal) + 1;

            } else {

                jumlahSore.value = "";

            }


            hitungTotal();

            updateProgress();

        }


        if (awalPagi) {

            awalPagi.addEventListener(
                "input",
                hitungPagi
            );

        }


        if (akhirPagi) {

            akhirPagi.addEventListener(
                "input",
                hitungPagi
            );

        }


        if (awalSore) {

            awalSore.addEventListener(
                "input",
                hitungSore
            );

        }


        if (akhirSore) {

            akhirSore.addEventListener(
                "input",
                hitungSore
            );

        }


        /* =====================================================
           TOTAL
        ====================================================== */

        function hitungTotal() {

            const pagi =
                parseInt(
                    jumlahPagi?.value
                )
                || 0;


            const sore =
                parseInt(
                    jumlahSore?.value
                )
                || 0;


            if (totalNotice) {

                totalNotice.textContent =
                    pagi + sore;

            }

        }


        /* =====================================================
           PROGRESS
        ====================================================== */

        function updateProgress() {

            if (!progressBar) {

                return;

            }


            let persen = 0;


            if (
                jumlahPagi &&
                jumlahPagi.value
            ) {

                persen = 50;

            }


            if (
                cardSore &&
                cardSore.style.display === "none"
            ) {

                persen = 100;

            }


            if (
                jumlahPagi?.value &&
                jumlahSore?.value
            ) {

                persen = 100;

            }


            progressBar.style.width =
                persen + "%";


            progressBar.textContent =
                persen + "%";

        }


        /* =====================================================
           SIMPAN DATA (Dikirim ke Backend via POST standard)
        ====================================================== */
        // Event listener di-remove agar form tersubmit normal ke controller



        /* =====================================================
           DEFAULT
        ====================================================== */

        cardSore.style.display =
            "none";


        hitungTotal();

        updateProgress();

    }
);