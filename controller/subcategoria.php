<?php
        require_once("../config/conexion.php");
        require_once("../models/Subcategoria.php");
        $subcategoria = new Subcategoria();

        switch($_GET["op"]){
//! --------------------------------------------------------------------------------------------------*/
            case "guardaryeditar":
                if(empty($_POST["subc_id"])){
                    $subcategoria->insert_subcategoria($_POST["cat_id"],$_POST["subc_nom"]);     
                }else {
                    $subcategoria->update_subcategoria($_POST["subc_id"],$_POST["cat_id"],$_POST["subc_nom"]);
                }
                break;
    //! --------------------------------------------------------------------------------------------------*/
            case "listar":
                $datos=$subcategoria->get_subcategoria_all();
                $data= Array();
                foreach($datos as $row){
                    $sub_array = array();
                    $sub_array[] = $row["cat_nom"];
                    $sub_array[] = $row["subc_nom"];
                    $sub_array[] = '<button type="button" onClick="editar('.$row["subc_id"].');"  id="'.$row["subc_id"].'" class="btn btn-inline btn-warning btn-sm ladda-button"><i class="fa fa-edit"></i></button>';
                    $sub_array[] = '<button type="button" onClick="eliminar('.$row["subc_id"].');"  id="'.$row["subc_id"].'" class="btn btn-inline btn-danger btn-sm ladda-button"><i class="fa fa-trash"></i></button>';
                    $data[] = $sub_array;
                }
    
                $results = array(
                    "sEcho"=>1,
                    "iTotalRecords"=>count($data),
                    "iTotalDisplayRecords"=>count($data),
                    "aaData"=>$data);
                echo json_encode($results);
                break;
    //! --------------------------------------------------------------------------------------------------*/
            case "eliminar":
                $subcategoria->delete_subcategoria($_POST["subc_id"]);
                break;
    //! --------------------------------------------------------------------------------------------------*/
            case "mostrar";
                $datos=$subcategoria->get_subcategoria_x_id($_POST["subc_id"]);  
                if(is_array($datos)==true and count($datos)>0){
                    foreach($datos as $row)
                    {
                        $output["subc_id"] = $row["subc_id"];
                        $output["cat_id"] = $row["cat_id"];
                        $output["subc_nom"] = $row["subc_nom"];
                    }
                    echo json_encode($output);
                }
                break;
    //! --------------------------------------------------------------------------------------------------*/
            case  "combo":
                $datos = $subcategoria->get_subcategoria($_POST["cat_id"]);
                $html = "";
                if(is_array($datos)==true and count($datos)>0){
                    $html.="<option label='Seleccionar'></option>";
                    foreach($datos as $row){
                        
                        $html.= "<option value='".$row['subc_id']."'>".$row['subc_nom']."</option>";
                    }
                    echo $html;

                }

                break;
        //! --------------------------------------------------------------------------------------------------*/

        }

?>