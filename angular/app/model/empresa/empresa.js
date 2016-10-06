"use strict";
var Empresa = (function () {
    function Empresa(id, municipioId, tipoEmpresaId, ciudadanoId, nit, nombre, direccion, telefono, correo) {
        this.id = id;
        this.municipioId = municipioId;
        this.tipoEmpresaId = tipoEmpresaId;
        this.ciudadanoId = ciudadanoId;
        this.nit = nit;
        this.nombre = nombre;
        this.direccion = direccion;
        this.telefono = telefono;
        this.correo = correo;
    }
    return Empresa;
}());
exports.Empresa = Empresa;
//# sourceMappingURL=Empresa.js.map