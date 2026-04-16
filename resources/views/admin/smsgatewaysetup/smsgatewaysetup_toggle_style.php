<style>
/* =====================
   Toggle Switch CSS
   ===================== */
.toggle-switch {
    position: relative;
    display: inline-block;
    width: 50px;
    height: 26px;
    cursor: pointer;
    margin: 0;
}

.toggle-switch input {
    opacity: 0;
    width: 0;
    height: 0;
    position: absolute;
}

.toggle-switch .slider {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background-color: #ccc;
    border-radius: 50px;
    transition: 0.3s;
}

.toggle-switch .slider::before {
    content: '';
    position: absolute;
    height: 20px;
    width: 20px;
    left: 3px;
    bottom: 3px;
    background-color: #fff;
    border-radius: 50%;
    transition: 0.3s;
    box-shadow: 0 1px 3px rgba(0,0,0,0.2);
}

.toggle-switch input:checked + .slider {
    background-color: #28b89e;
}

.toggle-switch input:checked + .slider::before {
    transform: translateX(24px);
}

/* Form input style matching screenshot */
.form-control {
    border: 1px solid #e0e0e0;
    border-radius: 5px;
    padding: 8px 12px;
    font-size: 14px;
    color: #555;
    background: #fff;
}

.form-control:focus {
    border-color: #28b89e;
    box-shadow: 0 0 0 0.1rem rgba(40, 184, 158, 0.25);
    outline: none;
}

.card {
    box-shadow: 0 1px 6px rgba(0,0,0,0.07) !important;
}
</style>
