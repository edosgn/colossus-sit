"use strict";
var Ciudadano = (function () {
    function Ciudadano(id, tipoIdentificacionId, numeroIdentificacion, nombres, apellidos, direccion, telefono, correo) {
        this.id = id;
        this.tipoIdentificacionId = tipoIdentificacionId;
        this.numeroIdentificacion = numeroIdentificacion;
        this.nombres = nombres;
        this.apellidos = apellidos;
        this.direccion = direccion;
        this.telefono = telefono;
        this.correo = correo;
    }
    return Ciudadano;
}());
exports.Ciudadano = Ciudadano;
//# sourceMappingURL=Ciudadano.js.map