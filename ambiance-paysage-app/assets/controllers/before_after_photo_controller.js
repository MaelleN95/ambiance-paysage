import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
    static targets = ["overlay", "handle"];

    connect() {
        // position initiale : centre
        this.setPosition(this.element.clientWidth / 2);

        // état
        this.isDragging = false;

        // utiliser pointer events (unifie mouse + touch)
        this._onPointerDown = (e) => {
            e.preventDefault();
            this.isDragging = true;
            this.element.setPointerCapture?.(e.pointerId);
        };
        this._onPointerMove = (e) => {
            if (!this.isDragging) return;
            this.move(e.clientX);
        };
        this._onPointerUp = (e) => {
            this.isDragging = false;
            this.element.releasePointerCapture?.(e.pointerId);
        };

        this.handleTarget.addEventListener("pointerdown", this._onPointerDown);
        window.addEventListener("pointermove", this._onPointerMove);
        window.addEventListener("pointerup", this._onPointerUp);
        window.addEventListener("pointercancel", this._onPointerUp);

        // réagir au resize pour recalc position (si besoin)
        this._onResize = () => this.setPosition(this.element.clientWidth / 2);
        window.addEventListener("resize", this._onResize);
    }

    disconnect() {
        // cleanup listeners
        this.handleTarget.removeEventListener(
            "pointerdown",
            this._onPointerDown
        );
        window.removeEventListener("pointermove", this._onPointerMove);
        window.removeEventListener("pointerup", this._onPointerUp);
        window.removeEventListener("pointercancel", this._onPointerUp);
        window.removeEventListener("resize", this._onResize);
    }

    move(clientX) {
        const rect = this.element.getBoundingClientRect();
        let x = clientX - rect.left;
        x = Math.max(1, Math.min(x, rect.width -1));
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
    }


}
