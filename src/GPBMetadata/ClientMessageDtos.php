<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: ClientMessageDtos.proto

namespace GPBMetadata;

class ClientMessageDtos
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        $pool->internalAddGeneratedFile(hex2bin(
            "0ae9390a17436c69656e744d65737361676544746f732e70726f746f1215" .
            "52786e65742e4576656e7453746f72652e44617461228a010a084e657745" .
            "76656e7412100a086576656e745f696418012001280c12120a0a6576656e" .
            "745f7479706518022001280912190a11646174615f636f6e74656e745f74" .
            "797065180320012805121d0a156d657461646174615f636f6e74656e745f" .
            "74797065180420012805120c0a046461746118052001280c12100a086d65" .
            "74616461746118062001280c22e4010a0b4576656e745265636f72641217" .
            "0a0f6576656e745f73747265616d5f696418012001280912140a0c657665" .
            "6e745f6e756d62657218022001280512100a086576656e745f6964180320" .
            "01280c12120a0a6576656e745f7479706518042001280912190a11646174" .
            "615f636f6e74656e745f74797065180520012805121d0a156d6574616461" .
            "74615f636f6e74656e745f74797065180620012805120c0a046461746118" .
            "072001280c12100a086d6574616461746118082001280c120f0a07637265" .
            "6174656418092001280312150a0d637265617465645f65706f6368180a20" .
            "012803227b0a145265736f6c766564496e64657865644576656e7412310a" .
            "056576656e7418012001280b32222e52786e65742e4576656e7453746f72" .
            "652e446174612e4576656e745265636f726412300a046c696e6b18022001" .
            "280b32222e52786e65742e4576656e7453746f72652e446174612e457665" .
            "6e745265636f726422a7010a0d5265736f6c7665644576656e7412310a05" .
            "6576656e7418012001280b32222e52786e65742e4576656e7453746f7265" .
            "2e446174612e4576656e745265636f726412300a046c696e6b1802200128" .
            "0b32222e52786e65742e4576656e7453746f72652e446174612e4576656e" .
            "745265636f726412170a0f636f6d6d69745f706f736974696f6e18032001" .
            "280312180a10707265706172655f706f736974696f6e1804200128032289" .
            "010a0b57726974654576656e747312170a0f6576656e745f73747265616d" .
            "5f696418012001280912180a1065787065637465645f76657273696f6e18" .
            "0220012805122f0a066576656e747318032003280b321f2e52786e65742e" .
            "4576656e7453746f72652e446174612e4e65774576656e7412160a0e7265" .
            "71756972655f6d617374657218042001280822c9010a1457726974654576" .
            "656e7473436f6d706c6574656412360a06726573756c7418012001280e32" .
            "262e52786e65742e4576656e7453746f72652e446174612e4f7065726174" .
            "696f6e526573756c74120f0a076d657373616765180220012809121a0a12" .
            "66697273745f6576656e745f6e756d62657218032001280512190a116c61" .
            "73745f6576656e745f6e756d62657218042001280512180a107072657061" .
            "72655f706f736974696f6e18052001280312170a0f636f6d6d69745f706f" .
            "736974696f6e180620012803226e0a0c44656c65746553747265616d1217" .
            "0a0f6576656e745f73747265616d5f696418012001280912180a10657870" .
            "65637465645f76657273696f6e18022001280512160a0e72657175697265" .
            "5f6d617374657218032001280812130a0b686172645f64656c6574651804" .
            "200128082293010a1544656c65746553747265616d436f6d706c65746564" .
            "12360a06726573756c7418012001280e32262e52786e65742e4576656e74" .
            "53746f72652e446174612e4f7065726174696f6e526573756c74120f0a07" .
            "6d65737361676518022001280912180a10707265706172655f706f736974" .
            "696f6e18032001280312170a0f636f6d6d69745f706f736974696f6e1804" .
            "20012803225d0a105472616e73616374696f6e537461727412170a0f6576" .
            "656e745f73747265616d5f696418012001280912180a1065787065637465" .
            "645f76657273696f6e18022001280512160a0e726571756972655f6d6173" .
            "746572180320012808227c0a195472616e73616374696f6e537461727443" .
            "6f6d706c6574656412160a0e7472616e73616374696f6e5f696418012001" .
            "280312360a06726573756c7418022001280e32262e52786e65742e457665" .
            "6e7453746f72652e446174612e4f7065726174696f6e526573756c74120f" .
            "0a076d65737361676518032001280922730a105472616e73616374696f6e" .
            "577269746512160a0e7472616e73616374696f6e5f696418012001280312" .
            "2f0a066576656e747318022003280b321f2e52786e65742e4576656e7453" .
            "746f72652e446174612e4e65774576656e7412160a0e726571756972655f" .
            "6d6173746572180320012808227c0a195472616e73616374696f6e577269" .
            "7465436f6d706c6574656412160a0e7472616e73616374696f6e5f696418" .
            "012001280312360a06726573756c7418022001280e32262e52786e65742e" .
            "4576656e7453746f72652e446174612e4f7065726174696f6e526573756c" .
            "74120f0a076d65737361676518032001280922430a115472616e73616374" .
            "696f6e436f6d6d697412160a0e7472616e73616374696f6e5f6964180120" .
            "01280312160a0e726571756972655f6d617374657218022001280822e701" .
            "0a1a5472616e73616374696f6e436f6d6d6974436f6d706c657465641216" .
            "0a0e7472616e73616374696f6e5f696418012001280312360a0672657375" .
            "6c7418022001280e32262e52786e65742e4576656e7453746f72652e4461" .
            "74612e4f7065726174696f6e526573756c74120f0a076d65737361676518" .
            "0320012809121a0a1266697273745f6576656e745f6e756d626572180420" .
            "01280512190a116c6173745f6576656e745f6e756d626572180520012805" .
            "12180a10707265706172655f706f736974696f6e18062001280312170a0f" .
            "636f6d6d69745f706f736974696f6e180720012803226c0a095265616445" .
            "76656e7412170a0f6576656e745f73747265616d5f696418012001280912" .
            "140a0c6576656e745f6e756d62657218022001280512180a107265736f6c" .
            "76655f6c696e6b5f746f7318032001280812160a0e726571756972655f6d" .
            "61737465721804200128082296020a12526561644576656e74436f6d706c" .
            "6574656412490a06726573756c7418012001280e32392e52786e65742e45" .
            "76656e7453746f72652e446174612e526561644576656e74436f6d706c65" .
            "7465642e526561644576656e74526573756c74123a0a056576656e741802" .
            "2001280b322b2e52786e65742e4576656e7453746f72652e446174612e52" .
            "65736f6c766564496e64657865644576656e74120d0a056572726f721803" .
            "20012809226a0a0f526561644576656e74526573756c74120b0a07537563" .
            "636573731000120c0a084e6f74466f756e641001120c0a084e6f53747265" .
            "616d100212110a0d53747265616d44656c65746564100312090a05457272" .
            "6f72100412100a0c41636365737344656e6965641005228b010a10526561" .
            "6453747265616d4576656e747312170a0f6576656e745f73747265616d5f" .
            "696418012001280912190a1166726f6d5f6576656e745f6e756d62657218" .
            "022001280512110a096d61785f636f756e7418032001280512180a107265" .
            "736f6c76655f6c696e6b5f746f7318042001280812160a0e726571756972" .
            "655f6d61737465721805200128082298030a195265616453747265616d45" .
            "76656e7473436f6d706c65746564123b0a066576656e747318012003280b" .
            "322b2e52786e65742e4576656e7453746f72652e446174612e5265736f6c" .
            "766564496e64657865644576656e7412510a06726573756c741802200128" .
            "0e32412e52786e65742e4576656e7453746f72652e446174612e52656164" .
            "53747265616d4576656e7473436f6d706c657465642e5265616453747265" .
            "616d526573756c7412190a116e6578745f6576656e745f6e756d62657218" .
            "032001280512190a116c6173745f6576656e745f6e756d62657218042001" .
            "280512180a1069735f656e645f6f665f73747265616d180520012808121c" .
            "0a146c6173745f636f6d6d69745f706f736974696f6e180620012803120d" .
            "0a056572726f72180720012809226e0a105265616453747265616d526573" .
            "756c74120b0a07537563636573731000120c0a084e6f53747265616d1001" .
            "12110a0d53747265616d44656c657465641002120f0a0b4e6f744d6f6469" .
            "66696564100312090a054572726f72100412100a0c41636365737344656e" .
            "69656410052287010a0d52656164416c6c4576656e747312170a0f636f6d" .
            "6d69745f706f736974696f6e18012001280312180a10707265706172655f" .
            "706f736974696f6e18022001280312110a096d61785f636f756e74180320" .
            "01280512180a107265736f6c76655f6c696e6b5f746f7318042001280812" .
            "160a0e726571756972655f6d617374657218052001280822e6020a165265" .
            "6164416c6c4576656e7473436f6d706c6574656412170a0f636f6d6d6974" .
            "5f706f736974696f6e18012001280312180a10707265706172655f706f73" .
            "6974696f6e18022001280312340a066576656e747318032003280b32242e" .
            "52786e65742e4576656e7453746f72652e446174612e5265736f6c766564" .
            "4576656e74121c0a146e6578745f636f6d6d69745f706f736974696f6e18" .
            "0420012803121d0a156e6578745f707265706172655f706f736974696f6e" .
            "180520012803124b0a06726573756c7418062001280e323b2e52786e6574" .
            "2e4576656e7453746f72652e446174612e52656164416c6c4576656e7473" .
            "436f6d706c657465642e52656164416c6c526573756c74120d0a05657272" .
            "6f72180720012809224a0a0d52656164416c6c526573756c74120b0a0753" .
            "7563636573731000120f0a0b4e6f744d6f646966696564100112090a0545" .
            "72726f72100212100a0c41636365737344656e696564100322de030a1c43" .
            "726561746550657273697374656e74537562736372697074696f6e121f0a" .
            "17737562736372697074696f6e5f67726f75705f6e616d65180120012809" .
            "12170a0f6576656e745f73747265616d5f696418022001280912180a1072" .
            "65736f6c76655f6c696e6b5f746f7318032001280812120a0a7374617274" .
            "5f66726f6d18042001280512240a1c6d6573736167655f74696d656f7574" .
            "5f6d696c6c697365636f6e647318052001280512190a117265636f72645f" .
            "7374617469737469637318062001280812180a106c6976655f6275666665" .
            "725f73697a6518072001280512170a0f726561645f62617463685f73697a" .
            "6518082001280512130a0b6275666665725f73697a651809200128051217" .
            "0a0f6d61785f72657472795f636f756e74180a20012805121a0a12707265" .
            "6665725f726f756e645f726f62696e180b20012808121d0a15636865636b" .
            "706f696e745f61667465725f74696d65180c20012805121c0a1463686563" .
            "6b706f696e745f6d61785f636f756e74180d20012805121c0a1463686563" .
            "6b706f696e745f6d696e5f636f756e74180e20012805121c0a1473756273" .
            "6372696265725f6d61785f636f756e74180f20012805121f0a176e616d65" .
            "645f636f6e73756d65725f737472617465677918102001280922580a1c44" .
            "656c65746550657273697374656e74537562736372697074696f6e121f0a" .
            "17737562736372697074696f6e5f67726f75705f6e616d65180120012809" .
            "12170a0f6576656e745f73747265616d5f696418022001280922de030a1c" .
            "55706461746550657273697374656e74537562736372697074696f6e121f" .
            "0a17737562736372697074696f6e5f67726f75705f6e616d651801200128" .
            "0912170a0f6576656e745f73747265616d5f696418022001280912180a10" .
            "7265736f6c76655f6c696e6b5f746f7318032001280812120a0a73746172" .
            "745f66726f6d18042001280512240a1c6d6573736167655f74696d656f75" .
            "745f6d696c6c697365636f6e647318052001280512190a117265636f7264" .
            "5f7374617469737469637318062001280812180a106c6976655f62756666" .
            "65725f73697a6518072001280512170a0f726561645f62617463685f7369" .
            "7a6518082001280512130a0b6275666665725f73697a6518092001280512" .
            "170a0f6d61785f72657472795f636f756e74180a20012805121a0a127072" .
            "656665725f726f756e645f726f62696e180b20012808121d0a1563686563" .
            "6b706f696e745f61667465725f74696d65180c20012805121c0a14636865" .
            "636b706f696e745f6d61785f636f756e74180d20012805121c0a14636865" .
            "636b706f696e745f6d696e5f636f756e74180e20012805121c0a14737562" .
            "736372696265725f6d61785f636f756e74180f20012805121f0a176e616d" .
            "65645f636f6e73756d65725f73747261746567791810200128092289020a" .
            "2555706461746550657273697374656e74537562736372697074696f6e43" .
            "6f6d706c65746564126f0a06726573756c7418012001280e325f2e52786e" .
            "65742e4576656e7453746f72652e446174612e5570646174655065727369" .
            "7374656e74537562736372697074696f6e436f6d706c657465642e557064" .
            "61746550657273697374656e74537562736372697074696f6e526573756c" .
            "74120e0a06726561736f6e180220012809225f0a22557064617465506572" .
            "73697374656e74537562736372697074696f6e526573756c74120b0a0753" .
            "756363657373100012100a0c446f65734e6f744578697374100112080a04" .
            "4661696c100212100a0c41636365737344656e6965641003228a020a2543" .
            "726561746550657273697374656e74537562736372697074696f6e436f6d" .
            "706c65746564126f0a06726573756c7418012001280e325f2e52786e6574" .
            "2e4576656e7453746f72652e446174612e43726561746550657273697374" .
            "656e74537562736372697074696f6e436f6d706c657465642e4372656174" .
            "6550657273697374656e74537562736372697074696f6e526573756c7412" .
            "0e0a06726561736f6e18022001280922600a224372656174655065727369" .
            "7374656e74537562736372697074696f6e526573756c74120b0a07537563" .
            "63657373100012110a0d416c7265616479457869737473100112080a0446" .
            "61696c100212100a0c41636365737344656e69656410032289020a254465" .
            "6c65746550657273697374656e74537562736372697074696f6e436f6d70" .
            "6c65746564126f0a06726573756c7418012001280e325f2e52786e65742e" .
            "4576656e7453746f72652e446174612e44656c6574655065727369737465" .
            "6e74537562736372697074696f6e436f6d706c657465642e44656c657465" .
            "50657273697374656e74537562736372697074696f6e526573756c74120e" .
            "0a06726561736f6e180220012809225f0a2244656c657465506572736973" .
            "74656e74537562736372697074696f6e526573756c74120b0a0753756363" .
            "657373100012100a0c446f65734e6f744578697374100112080a04466169" .
            "6c100212100a0c41636365737344656e696564100322770a1f436f6e6e65" .
            "6374546f50657273697374656e74537562736372697074696f6e12170a0f" .
            "737562736372697074696f6e5f696418012001280912170a0f6576656e74" .
            "5f73747265616d5f696418022001280912220a1a616c6c6f7765645f696e" .
            "5f666c696768745f6d6573736167657318032001280522570a1f50657273" .
            "697374656e74537562736372697074696f6e41636b4576656e747312170a" .
            "0f737562736372697074696f6e5f6964180120012809121b0a1370726f63" .
            "65737365645f6576656e745f69647318022003280c22fd010a1f50657273" .
            "697374656e74537562736372697074696f6e4e616b4576656e747312170a" .
            "0f737562736372697074696f6e5f6964180120012809121b0a1370726f63" .
            "65737365645f6576656e745f69647318022003280c120f0a076d65737361" .
            "676518032001280912500a06616374696f6e18042001280e32402e52786e" .
            "65742e4576656e7453746f72652e446174612e50657273697374656e7453" .
            "7562736372697074696f6e4e616b4576656e74732e4e616b416374696f6e" .
            "22410a094e616b416374696f6e120b0a07556e6b6e6f776e100012080a04" .
            "5061726b100112090a055265747279100212080a04536b6970100312080a" .
            "0453746f70100422760a2250657273697374656e74537562736372697074" .
            "696f6e436f6e6669726d6174696f6e121c0a146c6173745f636f6d6d6974" .
            "5f706f736974696f6e18012001280312170a0f737562736372697074696f" .
            "6e5f696418022001280912190a116c6173745f6576656e745f6e756d6265" .
            "7218032001280522670a2950657273697374656e74537562736372697074" .
            "696f6e53747265616d4576656e744170706561726564123a0a056576656e" .
            "7418012001280b322b2e52786e65742e4576656e7453746f72652e446174" .
            "612e5265736f6c766564496e64657865644576656e7422460a1153756273" .
            "6372696265546f53747265616d12170a0f6576656e745f73747265616d5f" .
            "696418012001280912180a107265736f6c76655f6c696e6b5f746f731802" .
            "2001280822530a18537562736372697074696f6e436f6e6669726d617469" .
            "6f6e121c0a146c6173745f636f6d6d69745f706f736974696f6e18012001" .
            "280312190a116c6173745f6576656e745f6e756d62657218022001280522" .
            "4a0a1353747265616d4576656e74417070656172656412330a056576656e" .
            "7418012001280b32242e52786e65742e4576656e7453746f72652e446174" .
            "612e5265736f6c7665644576656e7422170a15556e737562736372696265" .
            "46726f6d53747265616d22f7010a13537562736372697074696f6e44726f" .
            "7070656412510a06726561736f6e18012001280e32412e52786e65742e45" .
            "76656e7453746f72652e446174612e537562736372697074696f6e44726f" .
            "707065642e537562736372697074696f6e44726f70526561736f6e228c01" .
            "0a16537562736372697074696f6e44726f70526561736f6e12100a0c556e" .
            "73756273637269626564100012100a0c41636365737344656e6965641001" .
            "120c0a084e6f74466f756e64100212210a1d50657273697374656e745375" .
            "62736372697074696f6e44656c657465641003121d0a1953756273637269" .
            "6265724d6178436f756e7452656163686564100422f1020a0a4e6f744861" .
            "6e646c656412420a06726561736f6e18012001280e32322e52786e65742e" .
            "4576656e7453746f72652e446174612e4e6f7448616e646c65642e4e6f74" .
            "48616e646c6564526561736f6e12170a0f6164646974696f6e616c5f696e" .
            "666f18022001280c1ac7010a0a4d6173746572496e666f121c0a14657874" .
            "65726e616c5f7463705f6164647265737318012001280912190a11657874" .
            "65726e616c5f7463705f706f7274180220012805121d0a1565787465726e" .
            "616c5f687474705f61646472657373180320012809121a0a126578746572" .
            "6e616c5f687474705f706f727418042001280512230a1b65787465726e61" .
            "6c5f7365637572655f7463705f6164647265737318052001280912200a18" .
            "65787465726e616c5f7365637572655f7463705f706f7274180620012805" .
            "223c0a104e6f7448616e646c6564526561736f6e120c0a084e6f74526561" .
            "64791000120b0a07546f6f427573791001120d0a094e6f744d6173746572" .
            "100222120a1053636176656e6765446174616261736522e8010a19536361" .
            "76656e67654461746162617365436f6d706c65746564124f0a0672657375" .
            "6c7418012001280e323f2e52786e65742e4576656e7453746f72652e4461" .
            "74612e53636176656e67654461746162617365436f6d706c657465642e53" .
            "636176656e6765526573756c74120d0a056572726f721802200128091215" .
            "0a0d746f74616c5f74696d655f6d7318032001280512190a11746f74616c" .
            "5f73706163655f736176656418042001280322390a0e53636176656e6765" .
            "526573756c74120b0a07537563636573731000120e0a0a496e50726f6772" .
            "6573731001120a0a064661696c656410022ab0010a0f4f7065726174696f" .
            "6e526573756c74120b0a0753756363657373100012120a0e507265706172" .
            "6554696d656f7574100112110a0d436f6d6d697454696d656f7574100212" .
            "120a0e466f727761726454696d656f7574100312180a1457726f6e674578" .
            "70656374656456657273696f6e100412110a0d53747265616d44656c6574" .
            "6564100512160a12496e76616c69645472616e73616374696f6e10061210" .
            "0a0c41636365737344656e6965641007620670726f746f33"
        ));

        static::$is_initialized = true;
    }
}

