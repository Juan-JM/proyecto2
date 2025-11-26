<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ConsumirServicioController extends Controller
{
    public function recolectarDatos(Request $request)
    {
        try {
            $respuestaToken = $this->obtenerToken();
            $tokenAcceso = $respuestaToken['values'];

            $comerceID = "d029fa3a95e174a19934857f535eb9427d967218a36ea014b70ad704bc6c8d1c";
            $moneda = 2;
            $telefono = $request->input('tnTelefono');
            $nombreUsuario = $request->input('tcRazonSocial');
            $ciNit = $request->input('tcCiNit');
            $nroPago = "tecno_gruposc-grupo-23" . rand(100000, 999999);
            $monto = $request->input('tnMonto');
            $correo = $request->input('tcCorreo');
            $serial = $request->input('tcSerial');
            $descuento = $request->input('tnDescuento');
            $total = $request->input('tnTotal');
            $urlCallback = route('url.callback');
            $urlReturn = url('/');
            $pedidoDetalle = $request->input('taPedidoDetalle');
            $url = "";

            if ($request->input('tnTipoServicio') == 1) {
                $url = "https://serviciostigomoney.pagofacil.com.bo/api/servicio/pagoqr";
            } elseif ($request->input('tnTipoServicio') == 2) {
                $url = "https://serviciostigomoney.pagofacil.com.bo/api/servicio/pagotigomoney";
            }

            $body = [
                "tcCommerceID" => $comerceID,
                "tnMoneda" => $moneda,
                "tnTelefono" => $telefono,
                "tcNombreUsuario" => $nombreUsuario,
                "tnCiNit" => $ciNit,
                "tcNroPago" => $nroPago,
                "tnMontoClienteEmpresa" => $monto,
                "tcCorreo" => $correo,
                "tcSerial" => $serial,
                "tnDescuento" => $descuento,
                "tnTotal" => $total,
                "tcUrlCallBack" => $urlCallback,
                "tcUrlReturn" => $urlReturn,
                "taPedidoDetalle" => $pedidoDetalle
            ];

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $tokenAcceso
            ])->post($url, $body);

            $result = $response->json();

            if (isset($result['data']['values'])) {
                $valuesString = $result['data']['values'];
                $parts = explode(';', $valuesString); // Dividir por ";"

                if (isset($parts[1])) {
                    $decodedValues = json_decode($parts[1], true);
                    $qrImage = $decodedValues['qrImage'] ?? null;
                    if ($qrImage) {
                        $qrImageBase64 = "data:image/png;base64," . $qrImage;
                        $result['qrImage'] = $qrImageBase64;
                    }
                }
            }

            return response()->json($result);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function consultarEstado(Request $request)
    {
        $transaccion = $request->input('tnTransaccion');

        $url = "https://serviciostigomoney.pagofacil.com.bo/api/servicio/consultartransaccion";

        $body = [
            "TransaccionDePago" => $transaccion
        ];

        $response = Http::post($url, $body);
        $result = $response->json();

        return response()->json($result);
    }

    public function urlCallback(Request $request)
    {
        return response()->json([
            'PedidoID' => $request->input("PedidoID"),
            'Fecha' => $request->input("Fecha"),
            'Hora' => $request->input("Hora"),
            'MetodoPago' => $request->input("MetodoPago"),
            'Estado' => $request->input("Estado"),
            'message' => 'Pago procesado correctamente'
        ]);
    }

    private function obtenerToken()
    {
        $url = "https://serviciostigomoney.pagofacil.com.bo/api/servicio/login";

        $body = [
            'TokenService' => '51247fae280c20410824977b0781453df59fad5b23bf2a0d14e884482f91e09078dbe5966e0b970ba696ec4caf9aa5661802935f86717c481f1670e63f35d5041c31d7cc6124be82afedc4fe926b806755efe678917468e31593a5f427c79cdf016b686fca0cb58eb145cf524f62088b57c6987b3bb3f30c2082b640d7c52907',
            'TokenSecret' => '9E7BC239DDC04F83B49FFDA5'
        ];

        $response = Http::post($url, $body);
        return $response->json();
    }
}
