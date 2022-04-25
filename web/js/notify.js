export class Notify {

    constructor(toastId, iconUrl, iconAlt, title, date, text, toastType){
        this.toastId = toastId;
        this.iconUrl = iconUrl;
        this.iconAlt = iconAlt;
        this.title = title;
        this.date = date;
        this.text = text;
        this.toastType = toastType;

        this.createNotification();
    }

    createNotification(){
        // Creamos la notificación
        const toast = document.createElement("div");
        switch (this.toastType) {
            case "primary":
                toast.setAttribute("style","background-color: #0d6efd;");
                break;

            case "secondary": 
                toast.setAttribute("style","background-color: #adb5bd;");
                break;

            case "success":
                toast.setAttribute("style","background-color: #198754;");
                break;

            case "danger":
                toast.setAttribute("style","background-color: #dc3545;color: white;");
                break;

            case "warning":
                toast.setAttribute("style","background-color: #ffc107;");
                break;

            case "info":
                toast.setAttribute("style","background-color: #0dcaf0;");
                break;

            default:
                break;
        }
        toast.setAttribute("class","toast");
        toast.setAttribute("id",this.toastId);
        toast.setAttribute("role","alert");
        toast.setAttribute("aria-live","assertive");
        toast.setAttribute("aria-atomic","true");
        toast.setAttribute("data-bs-autohide","false");

        // Creamos el contenedor del header
        const toastHeader = document.createElement("div");
        toastHeader.setAttribute("class","toast-header");
        //toastHeader.setAttribute("style","background-color: inherit");

        // Elementos del Header
        const toastIcon = document.createElement("img");
        toastIcon.setAttribute("class","rounded me-2");
        toastIcon.setAttribute("width","20")
        toastIcon.setAttribute("src",this.iconUrl);
        toastIcon.setAttribute("alt",this.iconAlt);

        const toastTitle = document.createElement("strong");
        toastTitle.setAttribute("class","me-auto fw-bold");
        toastTitle.innerHTML = this.title;

        const toastDate = document.createElement("small");
        toastDate.innerHTML = this.date;

        const toastButton = document.createElement("button");
        toastButton.setAttribute("class","btn-close");
        toastButton.setAttribute("type","button");
        toastButton.setAttribute("data-bs-dismiss","toast");
        toastButton.setAttribute("arial-label","Close");

        // Añadimos los elementos al header
        toastHeader.appendChild(toastIcon);
        toastHeader.appendChild(toastTitle);
        toastHeader.appendChild(toastDate);
        toastHeader.appendChild(toastButton);

        // Creamos el contenedor del body
        const toastBody = document.createElement("div");
        toastBody.setAttribute("class","toast-body");
        toastBody.innerHTML = this.text;

        // Añadimos el header y body a la notificación
        toast.appendChild(toastHeader);
        toast.appendChild(toastBody);

        // Mandamos la notificación a nuestro contenedor de notificaciones
        const container = document.getElementById("toastContainer");
        container.appendChild(toast);
    }

}