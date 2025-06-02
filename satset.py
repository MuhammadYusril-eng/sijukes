import time
import sys

lyrics = [
    "I praise Allah for sending me you my love",
    "You found me home and sail with me",
    "And I'm here with you",
    "Now let me let you know",
    "You've opened my heart",
    "",
    "I was always thinking that love was wrong",
    "But everything was changed when you came along",
    "Oh, and there's a couple words I want to say",
    "",
    "(Chorus)",
    "For the rest of my life",
    "I'll be with you",
    "I'll stay by your side honest and true",
    "Till the end of my time",
    "I'll be loving you, loving you",
    "",
    "For the rest of my life",
    "Thru days and night",
    "I'll thank Allah for open my eyes",
    "Now and forever I'll be there for you",
    "",
    "(Verse)",
    "I know that deep in my heart",
    "I feel so blessed when I think of you",
    "And I ask Allah to bless all we do",
    "You're my wife and my friend and my strength",
    "And I pray we're together in Jannah"
]

def print_scrolling_lyrics(delay=2.3):
    max_lines = 10 
    buffer = []    
    
    for line in lyrics:
        buffer.append(line)
        if len(buffer) > max_lines:
            buffer.pop(0)  
        
        sys.stdout.write("\033[H\033[J") 
        print("\n".join(buffer))
        sys.stdout.flush()
        
        time.sleep(delay)



# Main program
if __name__ == "__main__":
    print("For The Rest Of My Life - Maher Zain\n")
    input("Press Enter to start...")
    print_scrolling_lyrics(delay=2.3)