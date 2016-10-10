"use strict";
var CiudadanoVehiculo = (function () {
    function CiudadanoVehiculo(id, ciudadanoId, vehiculoId, licenciaTransito, fechaPropiedadInicial, fechaPropiedadFinal, estadoPropiedad) {
        this.id = id;
        this.ciudadanoId = ciudadanoId;
        this.vehiculoId = vehiculoId;
        this.licenciaTransito = licenciaTransito;
        this.fechaPropiedadInicial = fechaPropiedadInicial;
        this.fechaPropiedadFinal = fechaPropiedadFinal;
        this.estadoPropiedad = estadoPropiedad;
    }
    return CiudadanoVehiculo;
}());
exports.CiudadanoVehiculo = CiudadanoVehiculo;
//# sourceMappingURL=ciudadanoVehiculo.js.map