"use strict";
var VehiculoPesado = (function () {
    function VehiculoPesado(id, modalidadId, vehiculoId, empresaId, tonelaje, numeroEjes, numeroMt, fichaTecnicaHomologacionCarroceria, fichaTecnicaHomologacionChasis) {
        this.id = id;
        this.modalidadId = modalidadId;
        this.vehiculoId = vehiculoId;
        this.empresaId = empresaId;
        this.tonelaje = tonelaje;
        this.numeroEjes = numeroEjes;
        this.numeroMt = numeroMt;
        this.fichaTecnicaHomologacionCarroceria = fichaTecnicaHomologacionCarroceria;
        this.fichaTecnicaHomologacionChasis = fichaTecnicaHomologacionChasis;
    }
    return VehiculoPesado;
}());
exports.VehiculoPesado = VehiculoPesado;
//# sourceMappingURL=VehiculoPesado.js.map