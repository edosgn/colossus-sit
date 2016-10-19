"use strict";
var CiudadanoVehiculo = (function () {
    function CiudadanoVehiculo(id, ciudadanoId, vehiculoId, empresaId, licenciaTransito, fechaPropiedadInicial, fechaPropiedadFinal, estadoPropiedad) {
        this.id = id;
        this.ciudadanoId = ciudadanoId;
        this.vehiculoId = vehiculoId;
        this.empresaId = empresaId;
        this.licenciaTransito = licenciaTransito;
        this.fechaPropiedadInicial = fechaPropiedadInicial;
        this.fechaPropiedadFinal = fechaPropiedadFinal;
        this.estadoPropiedad = estadoPropiedad;
    }
    return CiudadanoVehiculo;
}());
exports.CiudadanoVehiculo = CiudadanoVehiculo;
//# sourceMappingURL=CiudadanoVehiculo.js.map