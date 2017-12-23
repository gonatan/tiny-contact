<?php

use JeroenDesloovere\VCard;

/**
 * Controller
 *
 * @author magna
 */
class Controller extends AbstractController
{
    /**
     * @param Base $f3 F3 base object
     */
    public function beforeRoute(Base $f3)
    {
        // == prepare logger
        $this->_prepareLogger($f3);

        // == prepare model
        try {
            $filename = $f3->get('DB');
            $conn = new Sqlite($f3, $filename);
            $f3->set('model', new ContactModel($f3, $conn));
        } catch (Exception $e) {
            $f3->logger->addCritical($e->getMessage());
            $f3->logger->addCritical($e->getTraceAsString());
            throw $e;
        }
    }

    /**
     *
     * @param Base $f3 F3 base object
     */
    public function afterRoute(Base $f3)
    {
        $f3->logger->addDebug(__METHOD__, func_get_args());

        // == clear model
        // Due to a "bug" in F3 objects in hive are destructed if they are
        // passed to a view. Thats why I prefer to destruct the model before.
        $f3->clear('model');

        // == handle partial
        $this->_handlePartial($f3);

        return true;
    }

    /**
     * @param Base $f3 F3 base object
     */
    public function index(Base $f3)
    {
        $f3->logger->addDebug(__METHOD__, func_get_args());
        $filter = 'POST' === $f3->get('VERB') ? $f3->get('POST.filter') : [];
        $rows   = $f3->get('model')->findByFilter($filter);
        $f3->set('headline.h1', 'Contact manager');
        $f3->set('headline.h2', 'View contacts');
        $f3->set('rows', $rows);
        $f3->set('partial', 'html/index.phtml');
    }

    /**
     * @param Base $f3 F3 base object
     */
    public function form(Base $f3)
    {
        $f3->logger->addDebug(__METHOD__, func_get_args());
        $id = (int)$f3->get('PARAMS.id');
        if ($id) {
            $row = $f3->get('model')->findById($id);
        } else {
            $row = $f3->get('model')->build();
        }
        if ('POST' === $f3->get('VERB')) {
            $row = $f3->get('POST.row');
            if ($row['id']) {
                $succ = $f3->get('model')->update($row);
            } else {
                $succ = $f3->get('model')->insert($row);
            }
            if (!$succ) {
                throw new Exception('could not update database');
            }
        }
        $f3->set('headline.h1', 'Contact manager');
        $f3->set('headline.h2', 'View contact');
        $f3->set('row', $row);
        $f3->set('partial', 'html/form.phtml');
    }

    /**
     * @param Base $f3 F3 base object
     */
    public function delete(Base $f3)
    {
        $f3->logger->addDebug(__METHOD__, func_get_args());
        $id = (int)$f3->get('PARAMS.id');
        $f3->get('model')->delete($id);
        $this->index($f3);
    }

    /**
     * @param Base $f3 F3 base object
     */
    public function vcard(Base $f3)
    {
        $f3->logger->addDebug(__METHOD__, func_get_args());
        $id    = (int)$f3->get('PARAMS.id');
        $row   = $f3->get('model')->findById($id);
        $vcard = new VCard\VCard();
        $vcard->addName($row['lastname'], $row['firstname']);
        if ($row['email']) {
            $vcard->addEmail($row['email']);
        }
        if ($row['phone']) {
            $vcard->addPhoneNumber($row['phone'], 'HOME');
        }
        if ($row['mobile']) {
            $vcard->addPhoneNumber($row['mobile'], 'CELL');
        }
        if ($row['street'] || $row['city'] || $row['zip']) {
            $name = $extended = $region = $country = '';
            $vcard->addAddress($name, $extended, $row['street'], $row['city'], $region, $row['zip'], $country, 'HOME');
        }
        $out = $vcard->getOutput();
        header('Content-Type: text/vcard');
        header('Content-Disposition: inline; filename= "vcard.vcf"');
        header('Content-Length: ' . mb_strlen($out));
        echo $out;
    }
}
