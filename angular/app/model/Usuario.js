"use strict";
var Usuario = (function () {
    function Usuario(id, nombres, apellidos, identificacion, correo, foto, telefono, fecha_nacimiento, estado, rol, password) {
        this.id = id;
        this.nombres = nombres;
        this.apellidos = apellidos;
        this.identificacion = identificacion;
        this.correo = correo;
        this.foto = foto;
        this.telefono = telefono;
        this.fecha_nacimiento = fecha_nacimiento;
        this.estado = estado;
        this.rol = rol;
        this.password = password;
    }
    return Usuario;
}());
exports.Usuario = Usuario;
//# sourceMappingURL=Usuario.js.map