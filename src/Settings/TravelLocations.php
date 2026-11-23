<?php

namespace Vendor\Settings;

final class TravelLocations
{
  private const MUNICIPALITIES = [
    "Bengo" => [
      "Dande" => "Dande (Caxito)",
      "Ambriz" => "Ambriz",
      "Dembos" => "Dembos (Quibaxe)"
    ],
    "Benguela" => [
      "Benguela" => "Benguela",
      "Lobito" => "Lobito",
      "Catumbela" => "Catumbela",
      "Cubal" => "Cubal",
      "Ganda" => "Ganda"
    ],
    "Bié" => [
      "Cuíto" => "Cuíto",
      "Andulo" => "Andulo",
      "Camacupa" => "Camacupa",
      "Chinguar" => "Chinguar"
    ],
    "Cabinda" => [
      "Cabinda" => "Cabinda",
      "Cacongo" => "Cacongo",
      "Buco-Zau" => "Buco-Zau"
    ],
    "Cuando" => [
      "Mavinga" => "Mavinga",
      "Cuito Cuanavale" => "Cuito Cuanavale",
      "Dirico" => "Dirico",
      "Rivungo" => "Rivungo"
    ],
    "Cubango" => [
      "Menongue" => "Menongue",
      "Cuchi" => "Cuchi",
      "Calai" => "Calai",
      "Cuangar" => "Cuangar"
    ],
    "Cuanza Norte" => [
      "Cazengo" => "Cazengo (N'dalatando)",
      "Cambambe" => "Cambambe (Dondo)",
      "Lucala" => "Lucala",
      "Ambaca" => "Ambaca (Camabatela)"
    ],
    "Cuanza Sul" => [
      "Sumbe" => "Sumbe",
      "Porto Amboim" => "Porto Amboim",
      "Amboim" => "Amboim (Gabela)",
      "Cela" => "Cela (Waku Kungo)",
      "Quibala" => "Quibala"
    ],
    "Cunene" => [
      "Cuanhama" => "Cuanhama (Ondjiva)",
      "Ombadja" => "Ombadja (Xangongo)",
      "Namacunde" => "Namacunde (Santa Clara)"
    ],
    "Huambo" => [
      "Huambo" => "Huambo",
      "Caála" => "Caála",
      "Bailundo" => "Bailundo",
      "Catchiungo" => "Catchiungo",
      "Longonjo" => "Longonjo"
    ],
    "Huíla" => [
      "Lubango" => "Lubango",
      "Matala" => "Matala",
      "Chibia" => "Chibia",
      "Caconda" => "Caconda",
      "Caluquembe" => "Caluquembe"
    ],
    "Icolo e Bengo" => [
      "Icolo e Bengo" => "Icolo e Bengo (Catete)",
      "Quiçama" => "Quiçama (Muxima)"
    ],
    "Luanda" => [
      "Luanda" => "Luanda",
      "Viana" => "Viana",
      "Cacuaco" => "Cacuaco",
      "Cazenga" => "Cazenga",
      "Belas" => "Belas",
      "Talatona" => "Talatona",
      "Kilamba Kiaxi" => "Kilamba Kiaxi"
    ],
    "Lunda Norte" => [
      "Chitato" => "Chitato (Dundo)",
      "Lucapa" => "Lucapa",
      "Cuango" => "Cuango",
      "Cambulo" => "Cambulo"
    ],
    "Lunda Sul" => [
      "Saurimo" => "Saurimo",
      "Dala" => "Dala",
      "Cacolo" => "Cacolo"
    ],
    "Malanje" => [
      "Malanje" => "Malanje",
      "Cacuso" => "Cacuso",
      "Calandula" => "Calandula",
      "Cangandala" => "Cangandala"
    ],
    "Moxico" => [
      "Moxico" => "Moxico (Luena)",
      "Camanongue" => "Camanongue",
      "Luchazes" => "Luchazes"
    ],
    "Moxico Leste" => [
      "Alto Zambeze" => "Alto Zambeze (Cazombo)",
      "Luacano" => "Luacano",
      "Luau" => "Luau",
      "Cameia" => "Cameia"
    ],
    "Namibe" => [
      "Moçâmedes" => "Moçâmedes",
      "Tômbwa" => "Tômbwa",
      "Bibala" => "Bibala",
      "Virei" => "Virei"
    ],
    "Uíge" => [
      "Uíge" => "Uíge",
      "Negage" => "Negage",
      "Maquela do Zombo" => "Maquela do Zombo",
      "Quitexe" => "Quitexe"
    ],
    "Zaire" => [
      "M'banza Kongo" => "M'banza Kongo",
      "Soyo" => "Soyo",
      "Nzeto" => "Nzeto",
      "Tomboco" => "Tomboco"
    ],
    "Destinos internacionais" => [
      "Santa Clara (Namíbia)" => "Santa Clara (Namíbia)",
      "Kinshasa (RDC)" => "Kinshasa (RDC)"
    ]
  ];

  public static function municipalitiesByProvince(): array
  {
    return self::MUNICIPALITIES;
  }

  public static function isValidSelection(string $province, string $municipality): bool
  {
    return isset(self::MUNICIPALITIES[$province][$municipality]);
  }

  public static function formatLocation(string $province, string $municipality): string
  {
    if (!self::isValidSelection($province, $municipality)) {
      throw new \InvalidArgumentException("The selected municipality does not belong to the selected province.");
    }

    $label = self::MUNICIPALITIES[$province][$municipality];

    return $province === "Destinos internacionais"
      ? $label
      : $label . ", " . $province;
  }

  public static function findSelection(string $location): ?array
  {
    foreach (self::MUNICIPALITIES as $province => $municipalities) {
      foreach ($municipalities as $municipality => $label) {
        if ($location === $municipality || $location === $label) {
          return [
            "province" => $province,
            "municipality" => $municipality
          ];
        }
      }
    }

    return null;
  }
}
