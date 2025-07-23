<?php
require_once(__DIR__ . '/../CONFIG/database.php');
require_once(__DIR__ . '/../MODELS/productos.php');

class ProductosController
{
    private $db;
    private $productos;

    public function __construct()
    {
        $database = new DB_conceptBPO();
        $this->db = $database->getConnection();
        $this->productos = new Productos($this->db);
    }

    public function create()
    {
        $data = json_decode(file_get_contents('php://input'));

        if (
            !empty($data->nombre) &&
            !empty($data->descripcion) &&
            !empty($data->rentabilidad) &&
            !empty($data->riesgo)
        ) {
            $this->productos->nombre = $data->nombre;
            $this->productos->descripcion = $data->descripcion;
            $this->productos->rentabilidad = $data->rentabilidad;
            $this->productos->riesgo = $data->riesgo;

            if ($this->productos->create()) {
                http_response_code(201);
                echo json_encode(['message' => 'El producto se creó con éxito']);
            } else {
                http_response_code(503);
                echo json_encode(['message' => 'Error al crear el producto']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Faltan datos requeridos']);
        }
    }

    public function show($id)
    {
        $producto = $this->productos->getById($id);

        if ($producto) {
            echo json_encode($producto);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "Producto no encontrado"]);
        }
    }

    public function read()
    {
        $stmt = $this->productos->read();
        $num = $stmt->rowCount();

        if ($num > 0) {
            $productos_arr = [];
            $productos_arr['registros'] = [];

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);

                $productos_items = [
                    'id' => $id,
                    'nombre' => $nombre,
                    'descripcion' => $descripcion,
                    'rentabilidad' => $rentabilidad,
                    'riesgo' => $riesgo
                ];
                array_push($productos_arr['registros'], $productos_items);
            }
            http_response_code(200);
            echo json_encode($productos_arr);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'No se encontraron registros']);
        }
    }

    public function update()
    {
        $data = json_decode(file_get_contents('php://input'));

        if (
            !empty($data->nombre) &&
            !empty($data->descripcion) &&
            !empty($data->rentabilidad) &&
            !empty($data->riesgo) &&
            !empty($data->id)
        ) {
            $this->productos->nombre = $data->nombre;
            $this->productos->descripcion = $data->descripcion;
            $this->productos->rentabilidad = $data->rentabilidad;
            $this->productos->riesgo = $data->riesgo;
            $this->productos->id = $data->id;

            if ($this->productos->update()) {
                http_response_code(200);
                echo json_encode(['message' => 'El producto se actualizó']);
            } else {
                http_response_code(503);
                echo json_encode(['message' => 'Error al actualizar el producto']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Faltan datos requeridos']);
        }
    }

    public function delete()
    {
        $data = json_decode(file_get_contents('php://input'));

        if (!empty($data->id)) {
            $this->productos->id = $data->id;

            if ($this->productos->delete()) {
                http_response_code(200);
                echo json_encode(['message' => 'El producto se eliminó']);
            } else {
                http_response_code(503);
                echo json_encode(['message' => 'Error al eliminar el producto']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Faltan datos requeridos']);
        }
    }
}
