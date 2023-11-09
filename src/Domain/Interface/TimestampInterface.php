<?php

namespace App\Domain\Interface;

interface TimestampInterface
{
    public function setCreatedAt(\DateTimeInterface $createdAt): void;

    public function getCreatedAt(): \DateTimeInterface;

    public function setUpdatedAt(\DateTimeInterface $updatedAt): void;

    public function getUpdatedAt(): \DateTimeInterface;

    public function setDeletedAt(?\DateTime $deletedAt): void;

    public function getDeletedAt(): ?\DateTimeInterface;
}
