<?php

class Plussia_Test_Character {

    //Возвращаем массив ответов на вопросы пользователя с $userId
    //ключи возвращаемого массива
    //0 - UserId
    //1 - Сила(уверенность)
    //2 - Твёрдость(надёжность)
    //3 - Широта(внимательность)
    //4 - Нежность(хрупкость)
    //5 - Мягкость(заботливость)
    //6 - Беспечность (беспечность)
    public function getAnswers($userId) {
        $rows = Model_NicCard::getCharacterForUser($userId);
        return $rows;
    }

    public function getUserPercent($user_id) {
        $ans = $this->getAnswers($user_id);
        $result = array();
        $all = 0;
        for ($i = 1; $i <= 6; $i++) {
            $all += $ans[$i];
        }
        for ($i = 1; $i <= 6; $i++) {
            $result[$i] = $all ? $ans[$i] / $all : 0;
            $result[$i] *= 100;
        }
        return $result;
    }

    //Возвращаем результат совпадений характеров в баллах
    //ключи возвращаемого массива
    //0 - Сила(уверенность)
    //1 - Твёрдость(надёжность)
    //2 - Широта(внимательность)
    //3 - Нежность(хрупкость)
    //4 - Мягкость(заботливость)
    //5 - Беспечность (беспечность)
    public function getGeneral($accountUser, $userId) {
        $ansAccUser = $this->getAnswers($accountUser);
        $ansCheckUser = $this->getAnswers($userId);
        for ($i = 1; $i <= 6; $i++) {
            if ($ansAccUser[$i] <= $ansCheckUser[$i])
                $ans[$i - 1] = $ansAccUser[$i];
            else
                $ans[$i - 1] = $ansCheckUser[$i];
        }
        return $ans;
    }

    //Вычисляем среднее арифметическое ответов необходдимо для вычисления общих черт в процентном соотношении
    public function srAr($accountUser, $userId) {
        $ansAccUser = $this->getAnswers($accountUser);
        $ansCheckUser = $this->getAnswers($userId);
        $result = 0;
        for ($i = 1; $i <= 6; $i++) {
            $result = $result + $ansAccUser[$i] + $ansCheckUser[$i];
        }

        $result/=12;

        return $result;
    }

    //Вычисление процентного соотношения общих качеств характера
    //ключи возвращаемого массива
    //0 - Сила(уверенность)
    //1 - Твёрдость(надёжность)
    //2 - Широта(внимательность)
    //3 - Нежность(хрупкость)
    //4 - Мягкость(заботливость)
    //5 - Беспечность (беспечность)
    public function getGeneralPersent($accUser, $checklUser) {
        $general = $this->getGeneral($accUser, $checklUser);
        $sr = $this->srAr($accUser, $checklUser);
        for ($i = 0; $i <= 5; $i++)
            $res[$i] = ($general[$i] * 100) / $sr;
        return $res;
    }

    //Вычисление процентного соотношения различий в чертах характера
    //ключи возвращаемого массива
    //0 - Сила(уверенность)
    //1 - Твёрдость(надёжность)
    //2 - Широта(внимательность)
    //3 - Нежность(хрупкость)
    //4 - Мягкость(заботливость)
    //5 - Беспечность (беспечность)
    function getDifferentPersent($accUser, $checklUser) {
        $general = $this->getGeneralPersent($accUser, $checklUser);
        for ($i = 0; $i <= 5; $i++)
            $res[$i] = 100 - $general[$i];
        return $res;
    }

    //Функция необходима для вычисления насколько пользователи дополняют друг друга
    function forUser($accUser, $checklUser) {
        $ansAccUser = $this->getAnswers($accUser);
        $ansCheckUser = $this->getAnswers($checklUser);
        for ($i = 1; $i <= 6; $i++) {
            if ($ansCheckUser[$i] - $ansAccUser[$i] > 0)
                $res[$i - 1] = $ansCheckUser[$i] - $ansAccUser[$i];
            else
                $res[$i - 1] = 0;
        }
        return $res;
    }

    //Процентное соотношение насколько пользователь дополняет спутника
    //ключи возвращаемого массива
    //0 - Сила(уверенность)
    //1 - Твёрдость(надёжность)
    //2 - Широта(внимательность)
    //3 - Нежность(хрупкость)
    //4 - Мягкость(заботливость)
    //5 - Беспечность (беспечность)
    function getUserCompl($accUser, $checkUser) {
        $points = $this->forUser($accUser, $checkUser);
        $sr = $this->srAr($accUser, $checkUser);
        for ($i = 0; $i <= 5; $i++)
            $res[$i] = ($points[$i] * 100) / $sr;
        return $res;
    }

    //Процентное соотношение насколько спутник дополняет пользователя
    //ключи возвращаемого массива
    //0 - Сила(уверенность)
    //1 - Твёрдость(надёжность)
    //2 - Широта(внимательность)
    //3 - Нежность(хрупкость)
    //4 - Мягкость(заботливость)
    //5 - Беспечность (беспечность)
    function getStlCompl($accUser, $checkUser) {
        $points = $this->forUser($checkUser, $accUser);
        $sr = $this->srAr($accUser, $checkUser);
        for ($i = 0; $i <= 5; $i++)
            $res[$i] = ($points[$i] * 100) / $sr;
        return $res;
    }

    //Вычисляем общий процент довместимости
    function getPersent($accUser, $checkUser) {
        $general = $this->getGeneralPersent($accUser, $checkUser);
        $points = $this->getUserCompl($accUser, $checkUser);
        $srGeneral = 0;
        $srPoints = 0;
        $j = 0;
        for ($i = 0; $i <= 5; $i++) {
            $srGeneral += $general[$i];
            $srPoints += $points[$i];
            if ($points[$i] != 0)
                $j++;
        }
        $srGeneral/=6;
        $srPoints/=$j;
        $srGeneral = ($srGeneral * 20) / 100;
        $srPoints = ($srPoints * 20) / 100;
        return $srGeneral + $srPoints;
    }

}

?>