<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class CatalogSeeder extends Seeder
{
    public function run(): void
    {
        $now = now(); // Para que todos tengan fecha de creación

        // 0. USUARIO ADMIN BASE (Si no existe)
        User::firstOrCreate(['id' => 1], [
            'username' => 'admin',
            'email' => 'admin@instituto.edu.pe',
            'password' => Hash::make('admin123'),
            'is_active' => true,
        ]);


        

        // 1. TIPOS DE DOCUMENTO
        DB::table('identity_document_types')->insertOrIgnore([
            ['id' => 1, 'name' => 'DNI', 'short_name' => 'DNI', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 2, 'name' => 'CARNET DE EXTRANJERÍA', 'short_name' => 'CE', 'created_at' => $now, 'updated_at' => $now],
        ]);

        // 2. TIPOS DE MATRÍCULA (Lista completa)
        $tiposMatricula = [
            [1, 'MATRÍCULA REGULAR'],
            [2, 'MATRÍCULA PARA SUBSANACIÓN'],
            [3, 'MATRÍCULA POR REINCORPORACIÓN'],
            [4, 'MATRÍCULA POR TRASLADO INTERNO'],
            [5, 'MATRÍCULA POR TRASLADO EXTERNO'],
            [6, 'MATRÍCULA POR CONVALIDACIÓN Y UBICACIÓN']
        ];
        foreach ($tiposMatricula as $tm) {
            DB::table('enrollment_types')->insertOrIgnore([
                'id' => $tm[0], 'name' => $tm[1], 'created_at' => $now, 'updated_at' => $now
            ]);
        }

        // 3. TURNOS
        $turnos = [[1, 'MAÑANA'], [2, 'TARDE'], [3, 'NOCHE']];
        foreach ($turnos as $t) {
            DB::table('shifts')->insertOrIgnore([
                'id' => $t[0], 'name' => $t[1], 'created_at' => $now, 'updated_at' => $now
            ]);
        }

        // 4. ÉTNIAS (MINEDU - Lista completa)
        $etnias = [
            [1, 'QUECHUA'], [2, 'AIMARA'], [3, 'NATIVO O INDÍGENA DE LA AMAZONÍA'],
            [4, 'PERTENECIENTE O PARTE DE OTRO PUEBLO INDÍGENA U ORIGINARIIO'],
            [5, 'NEGRO, MORENO, ZAMBO, MULATO / PUEBLO AFROPERUANO O AFRODESCENDIENTE'],
            [6, 'BLANCO'], [7, 'MESTIZO'], [8, 'OTRO']
        ];
        foreach ($etnias as $e) {
            DB::table('ethnicities')->insertOrIgnore([
                'id' => $e[0], 'name' => $e[1], 'created_at' => $now, 'updated_at' => $now
            ]);
        }

        // 5. LENGUAS (Las 70 del MINEDU)
        // Usamos un array gigante para insertarlo de una sola vez y que sea rápido
        $lenguas = [
            [1, 'ACHUAR (O ACHUAL)'], [2, 'AGUARUNA (O AWAJUN)'], [3, 'AIMARA'], [4, 'AMAHUACA'],
            [5, 'ARABELA'], [6, 'ASHANINKA'], [7, 'ASHENINKA'], [8, 'BORA'], [9, 'CASHINAHUA'],
            [10, 'CASTELLANO'], [11, 'CHAMICURO'], [12, 'CHAPRA'], [13, 'CHAYAHUITA (O SHAWI)'],
            [14, 'CHOLÓN'], [15, 'ESE EJA'], [16, 'HARAKBUT'], [17, 'HUAMBISA (O WAMPIS)'],
            [18, 'HUITOTO'], [19, 'IKITU'], [20, 'INGLÉS'], [21, 'IÑAPARI'], [22, 'ISKONAWA'],
            [23, 'JAQARU'], [24, 'KAKATAIBO'], [25, 'KAKINTE'], [26, 'KANDOZI'], [27, 'KAPANAWA'],
            [28, 'KAWKI'], [29, 'KICHWA'], [30, 'KUKAMA KUKAMIRIA'], [31, 'MADIJA'], [32, 'MAIJIKI'],
            [33, 'MATSÉS'], [34, 'MATSIGENKA'], [35, 'MATSIGENKA MONTETOKUNIRIRA'], [36, 'MUNICHE'],
            [37, 'NAHUA'], [38, 'NOMATSIGUENGA'], [39, 'OCAINA'], [40, 'OMAGUA'], [41, 'OTROS'],
            [42, 'QUECHUA ÁNCASH'], [43, 'QUECHUA CAJAMARCA'], [44, 'QUECHUA CENTRAL'],
            [45, 'QUECHUA CHANKA'], [46, 'QUECHUA COLLAO'], [47, 'QUECHUA DE LA SELVA'],
            [48, 'QUECHUA HUÁNUCO'], [49, 'QUECHUA JUNÍN (WANKA-YARU)'],
            [50, 'QUECHUA LAMBAYEQUE (INKAWASI KAÑARIS)'], [51, 'QUECHUA NORTEÑO'],
            [52, 'QUECHUA PASCO-YARU'], [53, 'QUECHUA SUREÑO'], [54, 'RESÍGARO'], [55, 'SECOYA'],
            [56, 'SHARANAHUA'], [57, 'SHIPIBO-KONIBO'], [58, 'SHIWILU'], [59, 'TAUSHIRO'],
            [60, 'TICUNA'], [61, 'URARINA'], [62, 'URO'], [63, 'YAGUA'], [64, 'YAMINAHUA'],
            [65, 'YANESHA (O AMUESHA)'], [66, 'YINE (O PIRO)'], [67, 'LENGUA EXTRANJERA: ÍNGLES'],
            [68, 'LENGUA EXTRANJERA: FRANCÉS'], [69, 'LENGUA EXTRANJERA: ALEMÁN'],
            [70, 'LENGUA EXTRANJERA: OTRO']
        ];

        $lenguasInsert = [];
        foreach ($lenguas as $l) {
            $lenguasInsert[] = ['id' => $l[0], 'name' => $l[1], 'created_at' => $now, 'updated_at' => $now];
        }
        // Insertamos en bloque para velocidad
        DB::table('languages')->insertOrIgnore($lenguasInsert);


        // 6. UBIGEO (Cajamarca por defecto)
        DB::table('ubigeos')->insertOrIgnore([
            ['id' => 1, 'code' => '060101', 'department' => 'CAJAMARCA', 'province' => 'CAJAMARCA', 'district' => 'CAJAMARCA', 'created_at' => $now, 'updated_at' => $now],
        ]);

        // 7. ESTADO CIVIL
        $civil = [
            [1, 'SOLTERO(A)'], [2, 'CASADO(A)'], [3, 'VIUDO(A)'], [4, 'DIVORCIADO(A)'], [5, 'OTRO']
        ];
        foreach ($civil as $c) {
            DB::table('marital_statuses')->insertOrIgnore([
                'id' => $c[0], 'name' => $c[1], 'created_at' => $now, 'updated_at' => $now
            ]);
        }

        // 8. BECAS (Lista Completa)
        $becas = [
            [1, 'BECA PRONABEC - BECA 18'],
            [2, 'BECA PRONABEC - BECA PERMANENCIA DE ESTUDIOS NACIONAL'],
            [3, 'BECA PRONABEC - BECA EXCELENCIA ACADÉMICA PARA HIJOS DE DOCENTES'],
            [4, 'BECA PRONABEC - BECA GENERACIÓN DEL BICENTENARIO'],
            [5, 'BECA PRONABEC - BECA HUALLAGA'],
            [6, 'BECA PRONABEC - BECA VRAEM'],
            [7, 'BECA PRONABEC - BECA CNA Y PA'],
            [8, 'BECA PRONABEC - BECA PROTECCIÓN'],
            [9, 'BECA PRONABEC - BECA EIB'],
            [10, 'BECA PRONABEC - BECA FF. AA'],
            [11, 'BECA PRONABEC - BECA REPARED'],
            [12, 'BECA OTROGADA POR LA INSTITUCIÓN'],
            [13, 'BECA OTROGADA POR LA MUNICIPALIDAD'],
            [14, 'BECA OTROGADA POR OTRA INSTANCIA'],
            [15, 'NINGUNA']
        ];
        foreach ($becas as $b) {
            DB::table('scholarship_types')->insertOrIgnore([
                'id' => $b[0], 'name' => $b[1], 'created_at' => $now, 'updated_at' => $now
            ]);
        }

        // 9. DISCAPACIDADES
        $discapacidad = [
            [1, 'PARA MOVERSE O CAMINAR Y/O USAR BRAZOS O PIERNAS'],
            [2, 'PARA VER'],
            [3, 'PARA OÍR'],
            [4, 'PARA ENTENDER O APRENDER'],
            [5, 'PARA RELACIONARSE CON LOS DEMÁS'],
            [6, 'PARA HABLAR O COMUNICARSE']
        ];
        foreach ($discapacidad as $d) {
            DB::table('disability_types')->insertOrIgnore([
                'id' => $d[0], 'name' => $d[1], 'created_at' => $now, 'updated_at' => $now
            ]);
        }
    }
}
