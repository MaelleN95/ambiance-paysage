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
        this.overlayTarget.style.width = `${x}px`;
        this.element.style.setProperty("--overlay-width", `${x}px`);
    }
}
