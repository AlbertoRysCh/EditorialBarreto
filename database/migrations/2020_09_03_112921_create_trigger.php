<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
        CREATE TRIGGER `libros_historial` AFTER INSERT ON `libros` FOR EACH ROW
        begin 
        insert into historiales(id,idlibros,idasesor,titulo,fechaOrden,fechaLlegada,fechaAsignacion,fechaCulminacion,
        fechaRevisionInterna,fechaEnvioPro,fechaHabilitacion,fechaEnvio,fechaAjustes,fechaAceptacion,fechaRechazo,
        idclasificacion,archivo,idstatu,ideditoriales)

        VALUES (NULL,
        NEW.id,NEW.idasesor,NEW.titulo,NEW.fechaOrden,NEW.fechaLlegada,NEW.fechaAsignacion,NEW.fechaCulminacion,
        NEW.fechaRevisionInterna,NEW.fechaEnvioPro,New.fechaHabilitacion,NEW.fechaEnvio,new.fechaAjustes,
        NEW.fechaAceptacion,NEW.fechaRechazo,NEW.idclasificacion,NEW.archivo,NEW.idstatu,NEW.ideditorial);
        end
        ');

        /*
        DB::unprepared('
        CREATE TRIGGER `update_libros` AFTER UPDATE ON `historiales` FOR EACH ROW
        begin 

        DECLARE id_exists Boolean;
               -- Check BookingRequest table
               SELECT 1
               INTO @id_exists
               FROM libros
               WHERE libros.id= NEW.ideditoriales;
        
               IF @id_exists = 1 and NEW.ideditoriales=24
               THEN
                   UPDATE libros
                     SET libros.fechaOrden = NEW.fechaOrden,
                     libros.fechaLlegada = NEW.fechaLlegada,
                     libros.fechaAsignacion = NEW.fechaAsignacion,
                     libros.fechaCulminacion = NEW.fechaCulminacion,
                     libros.fechaRevisionInterna = NEW.fechaRevisionInterna,
                     libros.fechaEnvioPro = NEW.fechaEnvioPro,
                     libros.fechaHabilitacion = NEW.fechaHabilitacion,
                     libros.fechaEnvio = NEW.fechaEnvio,
                     libros.fechaAjustes = NEW.fechaAjustes,
                     libros.fechaAceptacion = NEW.fechaAceptacion,
                     libros.fechaRechazo = NEW.fechaRechazo,
                     libros.idstatu = NEW.idstatu,
                     libros.idasesor = NEW.idasesor,
                     libros.idclasificacion = NEW.idclasificacion
                   WHERE libros.id = NEW.ideditoriales;
                   ELSE
                   UPDATE libros
         SET libros.fechaOrden = NEW.fechaOrden,
                    libros.fechaLlegada = NEW.fechaLlegada,
                    libros.fechaAsignacion = NEW.fechaAsignacion,
                    libros.fechaCulminacion = NEW.fechaCulminacion,
                    libros.fechaRevisionInterna = NEW.fechaRevisionInterna,
                    libros.fechaEnvioPro = NEW.fechaEnvioPro,
                    libros.fechaHabilitacion = NEW.fechaHabilitacion,
                    libros.fechaEnvio = NEW.fechaEnvio,
                    libros.fechaAjustes = NEW.fechaAjustes,
                    libros.fechaAceptacion = NEW.fechaAceptacion,
                    libros.fechaRechazo = NEW.fechaRechazo,
                    libros.idstatu = NEW.idstatu,
                    libros.idasesor = NEW.idasesor,
                    libros.ideditoriales = NEW.ideditoriales,
                    libros.idclasificacion = NEW.idclasificacion
                   WHERE libros.id = NEW.ideditoriales;
                END IF;
        end
        ');
        */
       
        DB::unprepared('
        CREATE TRIGGER `usuarios_asesor` AFTER INSERT ON `users` FOR EACH ROW
        begin 
        if new.idrol=3 then 
          insert into asesors (id,usuario_id,num_documento,nombres,telefono,correo,condicion,idtipoeditoriales) 
          VALUES (NULL,NEW.id,NEW.num_documento,NEW.nombre,NEW.telefono,NEW.email,1,2);
        end if;
        end
        ');

        DB::unprepared('
        CREATE TRIGGER `usuarios_asesorventas` AFTER INSERT ON `users` FOR EACH ROW
        begin 
        if new.idrol=4 then 
          insert into asesorventas (id,usuario_id,num_documento,nombres,telefono,correo,zona_id,condicion) 
          VALUES (NULL,NEW.id,NEW.num_documento,NEW.nombre,NEW.telefono,NEW.email,NEW.zona_id,1);
        end if;
        end
        ');

        DB::unprepared('
        CREATE TRIGGER `usuarios_asesorventas_update` AFTER UPDATE ON `users` FOR EACH ROW
        BEGIN 
        IF new.idrol=4 THEN 
          UPDATE asesorventas 
                    SET asesorventas.num_documento = NEW.num_documento,
                    asesorventas.nombres = NEW.nombre,
                    asesorventas.telefono = NEW.telefono,
                    asesorventas.correo = NEW.email,
                    asesorventas.zona_id = NEW.zona_id
                    WHERE asesorventas.usuario_id = NEW.id;
        END IF;
        END
        ');

        
        DB::unprepared('
        CREATE TRIGGER `tr_registrar_cuentas_por_cobrar` AFTER INSERT ON `ordentrabajo` FOR EACH ROW
        BEGIN
            INSERT INTO cuentas_por_cobrar
            (id,idordentrabajo,precio)
            VALUES (NULL,NEW.idordentrabajo,NEW.precio);
        END
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `libros_historial`');
        
        DB::unprepared('DROP TRIGGER `usuarios_asesor`');
        DB::unprepared('DROP TRIGGER `usuarios_asesorventas`');
        DB::unprepared('DROP TRIGGER `usuarios_asesorventas_update`');
        DB::unprepared('DROP TRIGGER `tr_registrar_cuentas_por_cobrar`');
    }
}
