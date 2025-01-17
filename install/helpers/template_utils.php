<?php
/*  Poweradmin, a friendly web-based admin tool for PowerDNS.
 *  See <https://www.poweradmin.org> for more details.
 *
 *  Copyright 2007-2010 Rejo Zenger <rejo@zenger.nl>
 *  Copyright 2010-2023 Poweradmin Development Team
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Component\Translation\Loader\PoFileLoader;
use Symfony\Component\Translation\Translator;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

function initializeTwigEnvironment($language) {
    $loader = new FilesystemLoader('templates');
    $twig = new Environment($loader);

    $translator = new Translator($language);
    $translator->addLoader('po', new PoFileLoader());
    $translator->addResource('po', getLocaleFile($language), $language);

    $twig->addExtension(new TranslationExtension($translator));

    return $twig;
}

function getCurrentStep(): int
{
    if (isset($_POST['step']) && is_numeric($_POST['step'])) {
        return $_POST['step'];
    }

    return 1;
}

function renderHeader($twig, $current_step): void
{
    echo $twig->render('header.html', array(
        'current_step' => htmlspecialchars($current_step),
        'file_version' => time()
    ));
}

function renderFooter($twig): void
{
    echo $twig->render('footer.html');
}
