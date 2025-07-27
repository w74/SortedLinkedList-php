<?php declare(strict_types=1);

namespace SortedLinkedList;

class LinkedListNode {
    public int|string $value;
    public ?self $next;
    public ?self $prev;

    public function __construct(int|string $val)
    {
        $this->value = $val;
        $this->prev = null;
        $this->next = null;
    }
}

class SortedLinkedList {
    public ?string $listType = null;
    public ?LinkedListNode $head = null;

    /**
     * Adds a new node to the linked list in ascending order
     *
     * @throws \RuntimeException
     */
    public function addValue(LinkedListNode $node): self
    {
        // if head doesn't exist, set the first value given as head and set the listType to whatever that value is
        if ($this->head === null) {
            if (is_string($node->value)) {
                $this->listType = 'string';
            } elseif (is_numeric($node->value)) {
                $this->listType = 'number';
            }

            $this->head = $node;
            // exit early
            return $this;
        }

        // check if new node's value matches the list's defined value
        if (
            ($this->listType === 'string' && !is_string($node->value)) ||
            ($this->listType === 'number' && !is_numeric($node->value))
        ) {
            throw new \RuntimeException('new LinkedListNode does not match list type');
        }

        // loop through nodes and try to find a larger value
        if ($node->value <= $this->head->value) {
            // if current value is less than head, set current value as new head
            $this->head->prev = $node;
            $node->next = $this->head;
            $this->head = $node;
        } else {
            // otherwise, iterate through list until we find a value equal or greater to the new node
            $currentNode = $this->head;

            while ($currentNode->next !== null && $currentNode->next->value < $node->value) {
                $currentNode = $currentNode->next;
            }

            // we should now either have the end of the list, or the node just preceding where the new node should be
            $node->next = $currentNode->next; // null if at end of list
            $node->prev = $currentNode;
            $currentNode->next = $node;
        }

        return $this;
    }

    /**
     * Removed a value from a list and links its precending and subsequent nodes
     */
    public function removeValue(LinkedListNode $node): self
    {
        $node->prev->next = $node->next;
        $node->next->prev = $node->prev;

        return $this;
    }

    public function printEntireList(): void
    {
        $current = $this->head;
        
        while ($current !== null) {
            echo $current->value . ',';
            $current = $current->next;
        }
    }
}