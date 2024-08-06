import JwtService from "@/core/services/JwtService";
import ApiService from "@/core/services/ApiService";
import { useI18n } from "vue-i18n";
import Swal from "sweetalert2/dist/sweetalert2.js";
import { ref } from "vue";
import axios from "axios";

export const Helper = {
    translate(data) {
        const { t, te } = useI18n();
        const text = data.replace(/\s|-/g, "");
        if (te(text)) {
            return t(text);
        } else {
            return data;
        }
    },

    test() {
        console.log("Halo Helper berhasil di panggil");
    },

    setCurrency2(number, format = "id-ID") {
        const a = new Intl.NumberFormat(format).format(number);
        return a;
    },

    setCurrency(number, lang) {
        let language = "US";
        if (lang !== undefined) language = lang;

        if (number === null || number === undefined) number = 0;
        let Currency = number;
        Currency = Currency.toLocaleString(language);
        Currency = Currency.toLocaleString(language);
        Currency = Currency.toLocaleString(language);
        Currency = Currency.toLocaleString(language);
        Currency = Currency.toLocaleString(language);
        Currency = Currency.toLocaleString(language);
        Currency = Currency.toLocaleString(language);
        Currency = Currency.toLocaleString(language);
        Currency = Currency.toLocaleString(language);
        Currency = Currency.toLocaleString(language);
        Currency = Currency.toLocaleString(language);
        return Currency;
    },

    logInfo(date, time = true) {
        const newDate = new Date(date),
            getDate = newDate.getDate(),
            getMonth = newDate.getMonth(),
            getYear = newDate.getFullYear(),
            getHours = newDate.getHours(),
            getMinutes = newDate.getMinutes();
        const months = [
            "Januari",
            "Februari",
            "Maret",
            "April",
            "Mei",
            "Juni",
            "Juli",
            "Agustus",
            "September",
            "Oktober",
            "November",
            "Desember",
        ];
        const res = `${getDate} ${months[getMonth]} ${getYear}
            ${time ? `- ${getHours}:${getMinutes}` : ""}`;
        return res;
    },

    getBulan(date) {
        const newDate = new Date(date),
            getMonth = newDate.getMonth();
        return getMonth + 1;
    },
    getBulanNow() {
        const newDate = new Date(),
            getMonth = newDate.getMonth();
        return getMonth + 1;
    },
    bulan(date) {
        const months = [
            "Januari",
            "Februari",
            "Maret",
            "April",
            "Mei",
            "Juni",
            "Juli",
            "Agustus",
            "September",
            "Oktober",
            "November",
            "Desember",
        ];
        const res = months[date - 1];
        return res;
    },

    checkUser() {
        return JwtService.getUser();
    },

    apiSerrviceGet(url) {
        return ApiService.get(url)
            .then(({ data }) => {
                return data.data;
            })
            .catch(({ response }) => {
                Swal.fire({
                    text: response.data.message,
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Try again!",
                    customClass: {
                        confirmButton: "btn fw-semobold btn-light-danger",
                    },
                });
                return null;
            });
    },
    persentase(awal, total) {
        const persen = (awal / total) * 100;
        return persen.toFixed(2);
    },

    getImage(path, name, thumbnail = false) {
        return ApiService.get('/getImage?image='+name+'&fieldid='+path+'&thumbnail='+thumbnail+'&apikey=bb8734d8ce88f5addb5b6dea5b8203b6462bcd6b')
        .then(({ data }) => {
            return data;
        });
    },
    replaceTextWA(text){
        const hasil = text.replace(/(\\r)*\\n/g, '<br>');
        return hasil;
    }
};
