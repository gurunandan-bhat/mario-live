<?php
class MarioDB extends PDO {

    public function __construct() {

        $dns = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;

        try {

            parent::__construct($dns, DB_USERNAME, DB_PASSWORD, array(
                PDO::ATTR_ERRMODE    => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_PERSISTENT => true,
            ));
        } catch (Exception $e) {

            echo "Error connecting to database: " . $e->getMessage();
        }
    }

    public function productMeta($urlName) {

        $query = <<<METAPROD
        SELECT
            p.vName pName,
            c.vName cName
        FROM
            product p join 
            prodcat c
        ON p.iPCatID = c.iPCatID
        WHERE
            p.vUrlName = :urlName
        METAPROD;

        try {
            $stmnt = $this->prepare($query);
            $stmnt->execute([':urlName' => $urlName]);
            $result = $stmnt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error executing $query: " . $e->getMessage());
        }

        return $result;
    }

    public function productAttributes($iProdID) {

        $query = <<<PRODATTRIB
        SELECT 
            a.vName attribName,
            pa.vValue attribValue
        FROM
            product_attrib pa JOIN
            attribute a
        ON
            pa.iAttribID = a.iAttribID
        WHERE
            pa.iProdID = :iProd1ID AND
            pa.iAttribDatID = 0 AND
            pa.fPrice = 0
        UNION
        SELECT
            a.vName attribName,
            pad.vName attribValue
        FROM
            prodcat_attrib_dat pad JOIN
            prodcat pc
        ON
            pad.iPCatID = pc.iPCatID
        JOIN 
            attribute a 
        ON
            a.iAttribID = pad.iAttribID
        JOIN
            product p
        ON
            pc.iPCatID = p.iPCatID
        WHERE
            p.iProdID = :iProd2ID
        PRODATTRIB;

        try {
            $stmnt = $this->prepare($query);
            $stmnt->execute(array(
                ':iProd1ID' => $iProdID,
                ':iProd2ID' => $iProdID
            ));
            $result = $stmnt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error executing $query: " . $e->getMessage());
        }

        return $result;
    }

    public function categoryMeta($urlName) {

        $query = <<<METAPRODCAT
        SELECT
            c.vName cName
        FROM
            prodcat c
        WHERE
            c.vUrlName = :urlName
        METAPRODCAT;

        try {
            $stmnt = $this->prepare($query);
            $stmnt->execute([':urlName' => $urlName]);
            $result = $stmnt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error executing $query: " . $e->getMessage());
        }

        return $result;
    }

    public function menuCategories() {

        $query = <<<MENUCAT
        SELECT
            iPCatID,
            vName,
            vUrlName,
            vMenuImage,
            vMenuImage_AltTag
        FROM
            prodcat
        WHERE
            iParentID = 0 AND
            cStatus   = 'A' AND
            iTopRank IS NOT NULL
        ORDER BY
            iTopRank
        MENUCAT;

        try {
            $result = $this->query($query);
        } catch (PDOException $e) {
            die("Error executing $query: " . $e->getMessage());
        }

        $menuCats = $result->fetchAll(PDO::FETCH_ASSOC);
        $countStmnt = $this->prepare("SELECT vUrlName FROM product WHERE iPCatID = ?");
        foreach ($menuCats as &$cat) {

            $countStmnt->execute([$cat['iPCatID']]);
            $catProds = $countStmnt->fetchAll(PDO::FETCH_ASSOC);

            $prodCount = count($catProds);
            if ($prodCount == 1) {
                $cat['vUrlName'] = "product/" . $catProds[0]['vUrlName'];
            } else {
                $cat['vUrlName'] = "category/" . $cat['vUrlName'];
            }
        }
        unset($cat);

        return $menuCats;
    }

    public function homepageSections() {

        $query = <<<HPSECTION
        SELECT
            hps.iHPSecID,
            hps.vName hpsName,
            p.iProdID,
            p.vName pName,
            p.vUrlName,
            p.vSmallImage,
            p.vSmallImage_AltTag,
            p.fOPrice,
            p.fPrice
        FROM
            homepage_section hps,
            homepage_section_dat hpsd,
            product p
        WHERE
            hps.cStatus = 'A' AND
            hps.iHPSecID = hpsd.iHPSecID AND
            hpsd.iProdID = p.iProdID AND
            p.cStatus = 'A'
        ORDER BY
            hps.iRank,
            p.iRank
        HPSECTION;

        try {
            $result = $this->query($query);
        } catch (PDOException $e) {
            die("Error executing $query: " . $e->getMessage());
        }

        $result    = $result->fetchAll(PDO::FETCH_ASSOC);
        $lastHPSID = -1;
        $sections  = [];

        foreach ($result as $row) {

            $products = array_splice($row, 2, 7);
            if ($row['iHPSecID'] != $lastHPSID) {

                // We have a new section not seen before
                // so we add that to the array

                $sections[] = $row;
                $lastHPSID = $row['iHPSecID'];
            }

            end($sections);
            $sections[key($sections)]['aProducts'][] = $products;
        }

        return $sections;
    }

    public function showcaseProducts() {

        $query = <<<SHOWCASE
        SELECT
            vLink,
            vPicTitle,
            vPic,
            vPic_AltTag
        FROM
            showcase
        WHERE
        cStatus = 'A'
        ORDER BY
        iRank
        SHOWCASE;

        try {
            $result = $this->query($query);
        } catch (PDOException $e) {
            die("Error executing $query: " . $e->getMessage());
        }

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function weeklyCartoons() {

        $query = <<<CARTOONS
        SELECT
            vTitle,
            vPic,
            vPic_AltTag
        FROM
            daily_cartoon
        WHERE
            cStatus = 'A'
        ORDER BY
            dDisplay DESC
        CARTOONS;

        try {
            $result = $this->query($query);
        } catch (PDOException $e) {
            die("Error executing $query: " . $e->getMessage());
        }

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function testimonials() {

        $query = <<<TESTIMONIALS
        SELECT
            person_name,
            comment
        FROM
            testimonials
        ORDER BY
        id
        TESTIMONIALS;

        try {
            $result = $this->query($query);
        } catch (PDOException $e) {
            die("Error executing $query: " . $e->getMessage());
        }

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function currencyCalculator(int $inrValue) {

        $query = <<<CURR
        SELECT
        vCurrencyCode,
        fINRValue
        FROM
        exchange_rates
        CURR;

        try {
            $result = $this->query($query);
        } catch (PDOException $e) {
            die("Error executing $query: " . $e->getMessage());
        }

        $rows = $result->fetchAll(PDO::FETCH_ASSOC);
        $value = array();
        foreach ($rows as $row) {

            $code = $row['vCurrencyCode'];
            $currencyValue = $inrValue / $row['fINRValue'];

            $value[$code] = number_format((float)($currencyValue), 2, '.', '');
        }

        return $value;
    }

    public function categoryTree() {

        $TABLE_COLUMNS = 6;

        $query = <<<CATTREEOPT
        select
            c1.iPCatID,
            c1.iParentID,
            c1.vName,
            c1.vUrlName,
            c1.vMenuImage,
            c1.vMenuImage_AltTag,
            c2.iPCatID,
            c2.iParentID,
            c2.vName,
            c2.vUrlName,
            c2.vMenuImage,
            c2.vMenuImage_AltTag,
            c3.iPCatID,
            c3.iParentID,
            c3.vName,
            c3.vUrlName,
            c3.vMenuImage,
            c2.vMenuImage_AltTag,
            count(p.iProdID)
        from
            prodcat c1
                left join prodcat c2 on c2.iParentID = c1.iPCatID
                left join prodcat c3 on c3.iParentID = c2.iPCatID
                join product p on p.iPCatID = coalesce(c3.iPCatID, c2.iPCatID, c1.iPCatID)
        where
            c1.iParentID = 0 and
            p.cStatus = 'A'
        group by
            c1.iPCatID,
            c1.iParentID,
            c1.vName,
            c1.vUrlName,
            c2.iPCatID,
            c2.iParentID,
            c2.vName,
            c2.vUrlName,
            c3.iPCatID,
            c3.iParentID,
            c3.vName,
            c3.vUrlName
        order by
            c1.iRank,
            c2.iRank,
            c3.iRank
        CATTREEOPT;

        try {
            $result = $this->query($query);
        } catch (PDOException $e) {
            die("Error executing $query: " . $e->getMessage());
        }

        // Fetch result as a simple array since column
        // names are repeated
        $result = $result->fetchAll(PDO::FETCH_NUM);

        $root = new Category();

        $lastCatID = $lastSubCatID = $lastSubSubCatID = -1;
        $cat = $subCat = $subSubCat = NULL;
        $index = array();

        foreach ($result as $row) {

            $count = array_pop($row);

            $tempCat = array_splice($row, 0, $TABLE_COLUMNS);
            if ($lastCatID != $tempCat[0]) {

                $cat = new Category($tempCat);
                $root->addSubCategory($cat);

                $lastCatID = $tempCat[0];

                $index[$cat->vUrlName] = $cat;
            }
            $cat->count += $count;

            $tempCat = array_splice($row, 0, $TABLE_COLUMNS);
            if ($tempCat[0]) {
                if ($lastSubCatID != $tempCat[0]) {

                    $subCat = new Category($tempCat);
                    $cat->addSubCategory($subCat);

                    $lastSubCatID = $tempCat[0];

                    $index[$subCat->vUrlName] = $subCat;
                }
                $subCat->count += $count;
            }

            $tempCat = array_splice($row, 0, $TABLE_COLUMNS);
            if ($tempCat[0]) {
                if ($lastSubSubCatID != $tempCat[0]) {

                    $subSubCat = new Category($tempCat);
                    $subCat->addSubCategory($subSubCat);

                    $lastSubSubCatID = $tempCat[0];

                    $index[$subSubCat->vUrlName] = $subSubCat;
                }
                $subSubCat->count += $count;
            }
        }

        return new CategoryTree($root, $index);
    }

    public function deepCategoryProducts($vUrlName) {

        $catQry = <<<CATQRY
            SELECT c1.vUrlName
            FROM prodcat c1 JOIN prodcat c2 ON c1.iParentID = c2.iPCatID
            WHERE c2.vUrlName = ? AND c1.cStatus = 'A'
        CATQRY;

        $prodQry = <<<PRODQRY
            SELECT  
                p.vUrlName vProdUrlName, p.vSmallImage vProdImage, p.vSmallImage_AltTag vProdImage_AltTag, 
                p.vName vProdName, p.iStockQty, p.iSold, p.fPrice 
            FROM product p JOIN prodcat c ON p.iPCatID = c.iPCatID 
            WHERE c.vUrlName = ? AND p.cStatus = 'A'
        PRODQRY;

        $products = array();
        $dbh = $this;
        $x = function ($vUrlName) use ($catQry, $prodQry, &$x, &$products) {
            try {
                $sth = $this->prepare($prodQry);
                $sth->execute([$vUrlName]);
            } catch (PDOException $e) {
                die("Error executing $prodQry: " . $e->getMessage());
            }
            $cProds = $sth->fetchAll(PDO::FETCH_ASSOC);
            $products = array_merge($products, $cProds);

            try {
                $sth = $this->prepare($catQry);
                $sth->execute([$vUrlName]);
            } catch (PDOException $e) {
                die("Error executing $catQry: " . $e->getMessage());
            }
            $cats = $sth->fetchAll(PDO::FETCH_ASSOC);

            if (count($cats) > 0) {
                foreach ($cats as $cat) {
                    $x($cat["vUrlName"]);
                }
            }
        };

        $x($vUrlName);
        return $products;
    }

    public function categoryProducts($categoryUrlName) {

        $query = <<<CATTREE
        SELECT
            c1.iPCatID,
            c1.vName,
            c1.vUrlName,
            c1.vMenuImage,
            c1.vMenuImage_AltTag,
            IFNULL(c2.iPCatID, 0) iSubCatID,
            c2.vName vSubCatName,
            c2.vUrlName vSubCatUrlName,
            c2.vMenuImage vSubCatMenuImage,
            c2.vMenuImage_AltTag vSubCatMenuImage_AltTag,
            c2.iTopRank,
            p.iPRodID,
            p.iPCatID iProdCatID,
            p.vName vProdName,
            p.vUrlName vProdUrlName,
            p.vSmallImage vProdImage,
            p.vSmallImage_AltTag vProdImage_AltTag,
            p.iStockQty,
            p.iSold,
            p.fPrice,
            p.fOPrice
        FROM
                  prodcat c1
        LEFT JOIN prodcat c2
        ON
            c2.iParentID = c1.iPCatID
        JOIN
            product p
        ON
            (p.iPCatID = c2.iPCatID OR
             p.iPCatID = c1.iPCatID)
        WHERE
            c1.vUrlName = ?
        AND c1.cStatus = 'A'
        AND p.cStatus = 'A'
        ORDER BY
            c1.iRank,
            c2.iRank,
            p.iRank
        CATTREE;

        try {
            $stmt = $this->prepare($query);
            $stmt->execute([$categoryUrlName]);
        } catch (PDOException $e) {
            die("Error executing $query: " . $e->getMessage());
        }

        $result      = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $lastCatID      = -1;
        $lastSubCatID   = -1;
        $tree           = [];

        foreach ($result as $row) {

            $product = array_splice($row, 10, 10);
            $subCat  = array_splice($row, 5, 5);

            if ($row['iPCatID'] != $lastCatID) {

                $row['aSubCats'] = [];
                $tree[] = $row;

                end($tree);

                $catIndex  = key($tree);
                $lastCatID = $row['iPCatID'];
            }

            if ($subCat['iSubCatID'] != $lastSubCatID) {

                $subCat['aProducts'] = [];
                $tree[$catIndex]['aSubCats'][] = $subCat;

                end($tree[$catIndex]['aSubCats']);

                $subCatIndex  = key($tree[$catIndex]['aSubCats']);
                $lastSubCatID = $subCat['iSubCatID'];
            }

            $tree[$catIndex]['aSubCats'][$subCatIndex]['aProducts'][] = $product;
        }

        return $tree;
    }

    public function createOrder(array $order) {

        $query = <<<CREATE_ORDER
            INSERT INTO orders (
                vBillName,
                vBillEmail,
                vBillAddress,
                vBillCity,
                vBillState,
                iBillCountyID,
                vBillPincode,
                vRecpName,
                vRecpEmail,
                vRecpAddress,
                vRecpCity,
                vRecpState,
                iRecpCountyID,
                vRecpPincode,
                fTotal,
                cPaymentType,
                cPaymentStatus,
                cStatus,
                vSource
            ) 
            VALUES (
                :vBillName,
                :vBillEmail,
                :vBillAddress,
                :vBillCity,
                :vBillState,
                :iBillCountyID,
                :vBillPincode,
                :vBillName,
                :vBillEmail,
                :vBillAddress,
                :vBillCity,
                :vBillState,
                :iBillCountyID,
                :vBillPincode,
                :fTotal,
                :cPaymentType,
                :cPaymentStatus,
                :cStatus,
                :vSource
            )
        CREATE_ORDER;

        $id = 0;
        try {
            $stmt = $this->prepare($query);
            $stmt->execute($order);

            $id = $this->lastInsertId();
        } catch (PDOException $e) {
            throw $e;
        }

        return $id;
    }

    public function createOrderProducts(array $products) {

        $qry = <<<CREATE_ORDER_PRODUCT
            INSERT INTO orders_dat (
                iOrdID,
                iProdID,
                fRate,
                iQty,
                fPayable
            ) VALUES (
                :iOrdID,
                :iProdID,
                :fRate,
                :iQty,
                :fPayable
            ) 
        CREATE_ORDER_PRODUCT;

        try {

            $this->beginTransaction();
            $stmnt = $this->prepare($qry);

            foreach ($products as $p) {
                $stmnt->execute($p);
            }
            $this->commit();
        } catch (Throwable $e) {
            $this->rollBack();
            throw $e;
        }
    }

    public function updateOrderResponse(array $response) {

        $qryUpdtOrder = <<<UPDATE_ORDER
            UPDATE orders SET cPaymentStatus = ? WHERE iOrdID = ?
        UPDATE_ORDER;

        $qryCreateCCAVResponse = <<<CREATE_RESPONSE
            INSERT INTO order_ccav_response (
                iOrdID,
                vSource,
                vOrderStatus,
                iTrackingID,
                fAmount,
                vCurrency,
                vBankRefNo,
                vFailureMessage,
                vPaymentMode,
                vCardName,
                iStatusCode,
                vStatusMessage
            ) VALUES (
                :iOrdID,
                :vSource,
                :vOrderStatus,
                :iTrackingID,
                :fAmount,
                :vCurrency,
                :vBankRefNo,
                :vFailureMessage,
                :vPaymentMode,
                :vCardName,
                :iStatusCode,
                :vStatusMessage
            )
        CREATE_RESPONSE;

        try {
            $this->beginTransaction();

            $updtStmnt = $this->prepare($qryUpdtOrder);
            $createStmnt = $this->prepare($qryCreateCCAVResponse);

            $updtStmnt->execute([$response['vOrderStatus'], $response['iOrdID']]);
            $createStmnt->execute($response);

            $this->commit();
        } catch (Throwable $e) {
            $this->rollBack();
            throw $e;
        }
    }
}
