<?php

namespace AitorGarcia\PortfolioBundle\Entity\Translation;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractTranslation;

/**
 * AitorGarcia\PortfolioBundle\Entity\Translation
 *
 * @ORM\Table(
 *     name="projects_translations",
 *     indexes={@ORM\Index(name="projects_translations_idx", columns={
 *         "locale", "object_class", "field", "foreign_key"
 *     })},
 *     uniqueConstraints={@ORM\UniqueConstraint(name="lookup_unique_idx", columns={
 *         "locale", "object_class", "field", "foreign_key"
 *     })}
 * )
 * @ORM\Entity(repositoryClass="Gedmo\Translatable\Entity\Repository\TranslationRepository")
 */
class ProjectTranslation extends AbstractTranslation
{
    /**
     * All required columns are mapped through inherited superclass
     */
}
