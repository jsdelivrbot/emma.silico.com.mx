<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class QuotesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = Faker::create();
        $quotes_text = [
            "Tigres, leones, panteras, elefantes, osos, perros, focas, delfines, caballos, camellos, chimpancés, gorilas, conejos, pulgas... ¡Todos han pasado por ello! Los únicos que nunca hemos hecho el imbécil en el circo... ¡somos los gatos!",
            "Me encantarían las mañanas si empezaran más tarde.",
            "Prefiero ponerme las botas que hacer ejercicio.",
            "¡Ay, qué bien me siento! Hoy tengo ganas de ser amable con todo el mundo. Algo me debe estar fallando.",
            "Algunos animales caseros nunca terminan lo que empiezan. Yo no soy como ellos. Mi filosofía es no empezar nunca nada.",
            "Otro día que termina. Otro día que no he hecho nada. Otro día perfecto.",
            "Odio los lunes.",
            "No hay que confundir la pereza con la apatía. Nosotros los perezosos no somos apáticos. Los apáticos no se interesan por nada. Nosotros nos interesamos, pero no hacemos nada.",
            "Quizá deba tomar menos café. Empieza a quitarme el sueño. Anoche me pasé al menos tres minutos dando vueltas en la cama sin poder dormir.",
            "Un gato pierde los pelos sólo en presencia de gente alérgica",
            "Es difícil ser humilde cuando se es el mejor.",
            "El dilema de mi vida: me levanto con hambre. Pero como y me da sueño",
            "Mi vida es una rutina, me levanto, voy al refrigerador, paso por debajo del camello...",
            "No solo soy una cara bonita... también soy un cuerpo bonito",
            "Soy lo bastante viejo como para ser más listo y lo suficientemente joven como para no preocuparme demasiado.",
            "Si quieres verte más delgado, júntate con gente más gorda que tú.",
            "El que inventó el lunes debería ser echado a la calle y ejecutado en el acto...",
            "Qué desfachatez, tomando ventaja de la bondad de John..., ese es MI trabajo",
            "En su primer comic: ¡Aliméntame!",
            "PORQUE TODO URGE PARA AYER SI YA CASI ES MAÑANA",
        ];

        // following line retrieve all the cat_ids from DB
        $cats = EMMA5\Cat::pluck('id')->all();
        $users = EMMA5\User::pluck('id')->all();
        foreach (range(1, 50) as $index) {
            $quote = EMMA5\Quote::create([
                'quote' => $quotes_text[array_rand($quotes_text)],
                'cat_id' => $faker->randomElement($cats),
                'user_id' => $faker->randomElement($users),
            ]);
        }
    }
}
