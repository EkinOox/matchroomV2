import React from "react";
import { ArrowRight } from "lucide-react";
import { cn } from "@/lib/utils";
import { useNavigate } from "react-router-dom"; // Importation de useNavigate

export const InteractiveHoverButton = React.forwardRef(({ children, className, to, ...props }, ref) => {
  const navigate = useNavigate(); // Initialisation de useNavigate

  // Fonction pour gérer la navigation
  const handleClick = () => {
    if (to) {
      navigate(to);
    }
  };

  return (
    <button
      ref={ref}
      onClick={handleClick} // Ajout de l'onClick pour la navigation
      className={cn(
        "group relative w-auto cursor-pointer overflow-hidden rounded-full border bg-background p-2 px-6 text-center font-semibold",
        className
      )}
      {...props}>
      <div className="flex items-center gap-2">
        <div
          className="h-2 w-2 rounded-full bg-primary transition-all duration-300 group-hover:scale-[100.8]"></div>
        <span
          className="inline-block transition-all duration-300 group-hover:translate-x-12 group-hover:opacity-0">
          {children}
        </span>
      </div>
      <div
        className="absolute top-0 z-10 flex h-full w-full translate-x-12 items-center justify-center gap-2 text-primary-foreground opacity-0 transition-all duration-300 group-hover:-translate-x-5 group-hover:opacity-100">
        <span>{children}</span>
        <ArrowRight />
      </div>
    </button>
  );
});

InteractiveHoverButton.displayName = "InteractiveHoverButton";
