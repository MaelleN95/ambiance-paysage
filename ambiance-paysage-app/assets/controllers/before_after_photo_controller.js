import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
    static targets = ["overlay", "handle"];

    connect() {
        this.dragOffset = 0;
        this.isDragging = false;
        this._captureTarget = null;

        // position initiale : centre
        this.setPosition(this.element.clientWidth / 2);

        // handlers
        this._onPointerDown = (e) => {
            e.preventDefault();
            this.isDragging = true;

            // mémoriser l'élément qui a reçu le pointerdown (pour la capture)
            this._captureTarget = e.currentTarget || e.target;

            // calcul du point de clic exact dans le handle
            const handleRect = this.handleTarget.getBoundingClientRect();
            this.dragOffset = e.clientX - handleRect.left;

            // demander la capture sur l'élément qui a reçu l'événement
            this._captureTarget.setPointerCapture?.(e.pointerId);
        };

        this._onPointerMove = (e) => {
            if (!this.isDragging) return;
            this.move(e.clientX);
        };

        this._onPointerUp = (e) => {
            this.isDragging = false;
            // relâcher la capture si on l'avait
            if (this._captureTarget) {
                this._captureTarget.releasePointerCapture?.(e.pointerId);
                this._captureTarget = null;
            }
        };

        // attacher le pointerdown au handle (c'est lui qu'on clique)
        this.handleTarget.addEventListener("pointerdown", this._onPointerDown);
        // mouvements et fin sur window pour suivre le pointer même en dehors du container
        window.addEventListener("pointermove", this._onPointerMove);
        window.addEventListener("pointerup", this._onPointerUp);
        window.addEventListener("pointercancel", this._onPointerUp);

        // resize
        this._onResize = () => this.setPosition(this.element.clientWidth / 2);
        window.addEventListener("resize", this._onResize);
    }

    disconnect() {
        this.handleTarget.removeEventListener("pointerdown", this._onPointerDown);
        window.removeEventListener("pointermove", this._onPointerMove);
        window.removeEventListener("pointerup", this._onPointerUp);
        window.removeEventListener("pointercancel", this._onPointerUp);
        window.removeEventListener("resize", this._onResize);
    }

    move(clientX) {
        const rect = this.element.getBoundingClientRect();
        const slopeWidth = 150;

        // x réel = position du pointeur - offset du clic dans le handle
        let x = clientX - rect.left - (this.dragOffset || 0) + slopeWidth / 2;

        // clamp
        x = Math.max(1, Math.min(x, rect.width - 1));
        this.setPosition(x);
    }

    setPosition(x) {
        const rect = this.element.getBoundingClientRect();
        const clampedX = Math.min(Math.max(0, x), rect.width);

        const overlayHeight = this.overlayTarget.clientHeight;
        const slopeWidth = 150;

        const p = clampedX / rect.width;

        let topX;
        if (p <= 0.75) {
            topX = clampedX;
        } else {
            const ratio = (p - 0.75) / 0.25;
            const start = rect.width * 0.75;
            const end = rect.width + slopeWidth;
            topX = start + (end - start) * ratio;
        }

        const bottomRightX = topX - slopeWidth;

        this.overlayTarget.style.clipPath = `polygon(
            0 0,
            ${topX}px 0,
            ${bottomRightX}px ${overlayHeight}px,
            0 ${overlayHeight}px
        )`;

        this.element.style.setProperty("--overlay-width", `${clampedX}px`);

        // --- Ligne blanche ---
        const sep = this.element.querySelector('.separator-line');
        const x1 = topX;
        const y1 = 0;
        const x2 = bottomRightX;
        const y2 = overlayHeight;
        const dx = x2 - x1;
        const dy = y2 - y1;
        const length = Math.sqrt(dx*dx + dy*dy);
        const angle = Math.atan2(dy, dx) * 180 / Math.PI;

        sep.style.left = `${x1}px`;
        sep.style.top = `${y1}px`;
        sep.style.height = `${length}px`;
        sep.style.transform = `rotate(${angle - 90}deg)`;

        // --- Arrows ---
        const arrows = this.element.querySelector('.before-after-photo-arrows');
        const midX = (x1 + x2) / 2;
        const midY = (y1 + y2) / 2;
        arrows.style.left = `${midX}px`;
        arrows.style.top = `${midY}px`;
        arrows.style.transform = `translate(-50%, -50%)`;
    }
}
