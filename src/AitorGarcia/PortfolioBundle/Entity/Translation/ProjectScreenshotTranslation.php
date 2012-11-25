<?php
/**
 * This file contains the ProjectScreenshotTranslation class.
 *
 * @author		Aitor García <aitor.falc@gmail.com>
 * @copyright	2012 Aitor García <aitor.falc@gmail.com>
 * @license		https://github.com/Falc/aitorgarcia.org/blob/master/LICENSE Simplified BSD License
 */

namespace AitorGarcia\PortfolioBundle\Entity\Translation;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractTranslation;

/**
 * Represents a project screenshot translation.
 *
 * @ORM\Table(
 *     name="project_screenshots_translations",
 *     indexes={@ORM\Index(name="project_screenshots_translations_idx", columns={
 *         "locale", "object_class", "field", "foreign_key"
 *     })},
 *     uniqueConstraints={@ORM\UniqueConstraint(name="lookup_unique_idx", columns={
 *         "locale", "object_class", "field", "foreign_key"
 *     })}
 * )
 * @ORM\Entity(repositoryClass="Gedmo\Translatable\Entity\Repository\TranslationRepository")
 */
class ProjectScreenshotTranslation extends AbstractTranslation
{
    /**
     * All required columns are mapped through inherited superclass
     */
}
